<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RefreshRdapBootstrap extends Command
{
    protected $signature   = 'rdap:refresh-bootstrap';
    protected $description = 'Refresh the IANA RDAP bootstrap registry cache';

    public function handle(): int
    {
        $this->info('Fetching IANA RDAP bootstrap...');

        try {
            $response = Http::timeout(15)->get('https://data.iana.org/rdap/dns.json');

            if (!$response->successful()) {
                $this->error('Failed to fetch bootstrap: HTTP ' . $response->status());
                return 1;
            }

            Cache::put('rdap_bootstrap', $response->json(), 86400);
            $this->info('Bootstrap cached successfully (' . count($response->json()['services'] ?? []) . ' TLD entries).');

            return 0;
        } catch (\Throwable $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
