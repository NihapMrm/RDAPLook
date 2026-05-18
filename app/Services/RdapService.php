<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RdapService
{
    private const BOOTSTRAP_URL      = 'https://data.iana.org/rdap/dns.json';
    private const BOOTSTRAP_CACHE_KEY = 'rdap_bootstrap';
    private const BOOTSTRAP_TTL      = 86400;
    private const RDAP_CACHE_TTL     = 86400;
    private const TIMEOUT            = 5;

    public function lookupDomain(string $domain): array
    {
        $cacheKey = 'rdap:' . strtolower($domain);

        return Cache::remember($cacheKey, self::RDAP_CACHE_TTL, function () use ($domain) {
            return $this->fetchAndNormalize($domain);
        });
    }

    public function checkAvailability(string $domain): array
    {
        $cacheKey = 'availability:' . strtolower($domain);

        return Cache::remember($cacheKey, 3600, function () use ($domain) {
            try {
                $data    = $this->fetchRdap($domain);
                $expires = null;

                foreach ($data['events'] ?? [] as $event) {
                    if (($event['eventAction'] ?? '') === 'expiration') {
                        $expires = $event['eventDate'] ?? null;
                    }
                }

                return [
                    'domain'     => $domain,
                    'registered' => true,
                    'expires'    => $expires,
                    'checked_at' => now()->toIso8601String(),
                ];
            } catch (DomainNotFoundException) {
                return [
                    'domain'     => $domain,
                    'registered' => false,
                    'expires'    => null,
                    'checked_at' => now()->toIso8601String(),
                ];
            }
        });
    }

    // -------------------------------------------------------------------------
    // Fetch helpers
    // -------------------------------------------------------------------------

    private function fetchAndNormalize(string $domain): array
    {
        $raw = $this->fetchRdap($domain);

        if ($this->isThinRegistry($domain)) {
            $raw = $this->mergeRegistrarData($raw);
        }

        return $this->normalize($raw, $domain);
    }

    private function fetchRdap(string $domain): array
    {
        $serverUrl = $this->resolveRdapServer($domain);
        $url       = rtrim($serverUrl, '/') . '/domain/' . urlencode($domain);

        $response = Http::timeout(self::TIMEOUT)
            ->withHeaders(['Accept' => 'application/rdap+json'])
            ->get($url);

        if ($response->status() === 404) {
            throw new DomainNotFoundException("Domain not found: {$domain}");
        }

        if (!$response->successful()) {
            throw new RdapUnavailableException("RDAP server returned {$response->status()} for {$domain}");
        }

        return $response->json() ?? [];
    }

    private function resolveRdapServer(string $domain): string
    {
        $tld      = $this->extractTld($domain);
        $tldLower = strtolower($tld);
        $bootstrap = $this->getBootstrap();

        foreach ($bootstrap['services'] ?? [] as $service) {
            [$tlds, $urls] = $service;
            if (\in_array($tld, $tlds, true) || \in_array($tldLower, $tlds, true)) {
                return $urls[0];
            }
        }

        return 'https://rdap.org/';
    }

    /**
     * Fetch and cache the IANA RDAP bootstrap registry.
     *
     * Guards against caching an empty or structurally invalid response so that
     * a transient IANA outage doesn't poison the cache for 24 hours and silently
     * route every TLD through the rdap.org fallback.
     */
    private function getBootstrap(): array
    {
        return Cache::remember(self::BOOTSTRAP_CACHE_KEY, self::BOOTSTRAP_TTL, function () {
            $response = Http::timeout(10)->get(self::BOOTSTRAP_URL);

            if (!$response->successful()) {
                throw new RdapUnavailableException(
                    'Cannot fetch IANA RDAP bootstrap registry (HTTP ' . $response->status() . ').'
                );
            }

            $data = $response->json() ?? [];

            if (empty($data['services'])) {
                throw new RdapUnavailableException(
                    'IANA RDAP bootstrap response is empty or malformed — not caching.'
                );
            }

            return $data;
        });
    }

    private function isThinRegistry(string $domain): bool
    {
        $tld = strtolower($this->extractTld($domain));
        return \in_array($tld, ['com', 'net'], true);
    }

    private function mergeRegistrarData(array $thin): array
    {
        foreach ($thin['links'] ?? [] as $link) {
            if (($link['rel'] ?? '') === 'related' && str_contains($link['href'] ?? '', 'rdap')) {
                try {
                    $registrar = Http::timeout(self::TIMEOUT)
                        ->withHeaders(['Accept' => 'application/rdap+json'])
                        ->get($link['href']);

                    if ($registrar->successful()) {
                        $thick             = $registrar->json() ?? [];
                        $thin['entities']  = array_merge($thin['entities'] ?? [], $thick['entities'] ?? []);

                        if (empty($thin['vcardArray']) && !empty($thick['vcardArray'])) {
                            $thin['vcardArray'] = $thick['vcardArray'];
                        }
                    }
                } catch (\Throwable) {
                    // Thin registry data is still usable; registrar enrichment is best-effort
                }
                break;
            }
        }

        return $thin;
    }

    // -------------------------------------------------------------------------
    // Normalization
    // -------------------------------------------------------------------------

    private function normalize(array $raw, string $domain): array
    {
        return [
            'domain'      => $domain,
            'registrar'   => $this->extractRegistrar($raw),
            'dates'       => $this->extractDates($raw),
            'nameservers' => $this->extractNameservers($raw),
            'status'      => $raw['status'] ?? [],
            'dnssec'      => $this->extractDnssec($raw),
            'contacts'    => $this->extractContacts($raw),
            '_raw'        => $raw,
        ];
    }

    private function extractDates(array $raw): array
    {
        $dates = ['registered' => null, 'updated' => null, 'expires' => null];

        foreach ($raw['events'] ?? [] as $event) {
            $action = $event['eventAction'] ?? '';
            $date   = $event['eventDate'] ?? null;

            match ($action) {
                'registration' => $dates['registered'] = $date,
                'last changed' => $dates['updated']    = $date,
                'expiration'   => $dates['expires']    = $date,
                default        => null,
            };
        }

        return $dates;
    }

    /**
     * Extract registrar info from entities.
     *
     * Reuses parseVcard() instead of hard-coding [1][1][3] — avoids TypeError
     * when the vcard structure is shallower than expected on some registrars.
     */
    private function extractRegistrar(array $raw): array
    {
        foreach ($raw['entities'] ?? [] as $entity) {
            if (!\is_array($entity['roles'] ?? null)) {
                continue;
            }

            if (\in_array('registrar', $entity['roles'], true)) {
                $card = $this->parseVcard($entity['vcardArray'] ?? []);

                return [
                    'name'    => $card['name'] ?? $entity['fn'] ?? null,
                    'iana_id' => $entity['publicIds'][0]['identifier'] ?? null,
                    'url'     => $entity['links'][0]['href'] ?? null,
                ];
            }
        }

        return ['name' => null, 'iana_id' => null, 'url' => null];
    }

    private function extractNameservers(array $raw): array
    {
        $ns = [];

        foreach ($raw['nameservers'] ?? [] as $nameserver) {
            $hostname = $nameserver['ldhName'] ?? $nameserver['unicodeName'] ?? null;
            if ($hostname) {
                $ns[] = strtolower($hostname);
            }
        }

        return $ns;
    }

    private function extractContacts(array $raw): array
    {
        $contacts = ['registrant' => null, 'admin' => null, 'tech' => null];

        $roleMap = [
            'registrant'     => 'registrant',
            'administrative' => 'admin',
            'technical'      => 'tech',
        ];

        foreach ($raw['entities'] ?? [] as $entity) {
            if (!\is_array($entity['roles'] ?? null)) {
                continue;
            }

            foreach ($roleMap as $role => $key) {
                if (\in_array($role, $entity['roles'], true)) {
                    $contacts[$key] = $this->parseVcard($entity['vcardArray'] ?? []);
                }
            }
        }

        return $contacts;
    }

    /**
     * Parse an RDAP vcardArray into a flat contact array.
     *
     * Defensive against:
     *  - vcardArray being empty or missing index 1
     *  - individual property entries that are not arrays
     *  - missing type/value slots within a property
     *  - org values delivered as arrays (some registrars send ["", "Org Name"])
     *  - adr values delivered as arrays (structured address components)
     */
    private function parseVcard(array $vcardArray): array
    {
        $contact = ['name' => null, 'org' => null, 'email' => null, 'country' => null];

        foreach ($vcardArray[1] ?? [] as $prop) {
            // Each property must be an array: [type, params, value-type, value]
            if (!\is_array($prop) || !isset($prop[0])) {
                continue;
            }

            $type  = strtolower((string) $prop[0]);
            $value = $prop[3] ?? null;

            match ($type) {
                'fn'    => $contact['name']    = \is_string($value) ? $value : null,
                'org'   => $contact['org']     = \is_array($value)
                                                    ? (trim($value[1] ?? $value[0] ?? '') ?: null)
                                                    : (\is_string($value) ? $value : null),
                'email' => $contact['email']   = \is_string($value) ? $value : null,
                'adr'   => $contact['country'] = \is_array($value)
                                                    ? (trim($value[6] ?? '') ?: null)
                                                    : null,
                default => null,
            };
        }

        return $contact;
    }

    private function extractDnssec(array $raw): bool
    {
        $signed = $raw['secureDNS']['delegationSigned'] ?? false;
        return $signed === true
            || \in_array(strtolower((string) $signed), ['true', '1'], true)
            || !empty($raw['secureDNS']['dsData'])
            || !empty($raw['secureDNS']['keyData']);
    }

    private function extractTld(string $domain): string
    {
        $parts = explode('.', $domain);
        return end($parts);
    }
}

class DomainNotFoundException extends \RuntimeException {}
class RdapUnavailableException extends \RuntimeException {}
