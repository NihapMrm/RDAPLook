<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class DnsRecordsCard extends Component
{
    public string $domain = '';
    public bool $loading = false;
    public array $records = [];
    public ?string $error = null;

    #[On('domainSearch')]
    public function startSearch(string $domain): void
    {
        $this->domain = $domain;
        $this->loading = true;
        $this->records = [];
        $this->error = null;
        $this->dispatch('load-dns-records');
    }

    #[On('load-dns-records')]
    public function loadRecords(): void
    {
        if (!$this->domain) {
            return;
        }

        try {
            $domain  = strtolower(trim($this->domain, '.'));
            $typeMap = DNS_A | DNS_AAAA | DNS_MX | DNS_NS | DNS_TXT | DNS_CNAME | DNS_SOA;
            $raw     = @dns_get_record($domain, $typeMap) ?: [];

            $results = ['A' => [], 'AAAA' => [], 'MX' => [], 'NS' => [], 'TXT' => [], 'CNAME' => [], 'SOA' => []];

            foreach ($raw as $record) {
                $type = $record['type'] ?? null;
                if (!array_key_exists($type, $results)) {
                    continue;
                }
                $results[$type][] = $this->normalizeRecord($record);
            }

            $this->records = array_filter($results, fn($r) => count($r) > 0);
        } catch (\Throwable) {
            $this->error = 'DNS lookup failed';
        } finally {
            $this->loading = false;
        }
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
            'TXT'   => $base + ['txt' => $record['txt'] ?? null],
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
            default => $base,
        };
    }

    public function render()
    {
        return view('livewire.dns-records-card');
    }
}
