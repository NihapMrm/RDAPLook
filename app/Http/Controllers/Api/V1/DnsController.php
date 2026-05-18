<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @group DNS Records
 */
class DnsController extends Controller
{
    private const RECORD_TYPES = [
        DNS_A, DNS_AAAA, DNS_MX, DNS_NS, DNS_TXT, DNS_CNAME, DNS_SOA,
    ];

    private const TYPE_NAMES = [
        DNS_A     => 'A',
        DNS_AAAA  => 'AAAA',
        DNS_MX    => 'MX',
        DNS_NS    => 'NS',
        DNS_TXT   => 'TXT',
        DNS_CNAME => 'CNAME',
        DNS_SOA   => 'SOA',
    ];

    /**
     * DNS records lookup
     *
     * Resolves all DNS record types for the given domain.
     *
     * @urlParam domain string required The domain name to resolve. Example: example.com
     *
     * @response 200 {
     *   "domain": "example.com",
     *   "records": {
     *     "A": [{"host": "example.com", "ip": "93.184.216.34", "ttl": 3600}],
     *     "MX": [{"host": "example.com", "target": "mail.example.com", "priority": 10, "ttl": 3600}]
     *   }
     * }
     */
    public function show(string $domain): JsonResponse
    {
        if (!$this->isValidDomain($domain)) {
            return $this->error('INVALID_DOMAIN', 'The provided domain name is invalid.', 422);
        }

        $domain  = strtolower(trim($domain, '.'));
        $results = [];
        $typeMap = DNS_A | DNS_AAAA | DNS_MX | DNS_NS | DNS_TXT | DNS_CNAME | DNS_SOA;

        $records = @dns_get_record($domain, $typeMap) ?: [];

        foreach (self::TYPE_NAMES as $type => $name) {
            $results[$name] = [];
        }

        foreach ($records as $record) {
            $type = $record['type'] ?? null;
            if (!isset($results[$type])) {
                continue;
            }
            $results[$type][] = $this->normalizeRecord($record);
        }

        return response()->json(['domain' => $domain, 'records' => $results]);
    }

    private function normalizeRecord(array $record): array
    {
        $type = $record['type'] ?? '';
        $base = ['host' => $record['host'] ?? null, 'ttl' => $record['ttl'] ?? null];

        return match ($type) {
            'A'     => $base + ['ip' => $record['ip'] ?? null],
            'AAAA'  => $base + ['ipv6' => $record['ipv6'] ?? null],
            'MX'    => $base + ['target' => $record['target'] ?? null, 'priority' => $record['pri'] ?? null],
            'NS'    => $base + ['target' => $record['target'] ?? null],
            'TXT'   => $base + ['txt' => $record['txt'] ?? null, 'entries' => $record['entries'] ?? []],
            'CNAME' => $base + ['target' => $record['target'] ?? null],
            'SOA'   => $base + [
                'mname'   => $record['mname'] ?? null,
                'rname'   => $record['rname'] ?? null,
                'serial'  => $record['serial'] ?? null,
                'refresh' => $record['refresh'] ?? null,
                'retry'   => $record['retry'] ?? null,
                'expire'  => $record['expire'] ?? null,
                'minimum' => $record['minimum-ttl'] ?? null,
            ],
            default => $base + $record,
        };
    }

    private function isValidDomain(string $domain): bool
    {
        return (bool) preg_match(
            '/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
            $domain
        );
    }

    private function error(string $code, string $message, int $status): JsonResponse
    {
        return response()->json(['error' => true, 'code' => $code, 'message' => $message], $status);
    }
}
