<?php

namespace App\Livewire;

use App\Services\RdapService;
use Livewire\Attributes\On;
use Livewire\Component;

class BulkCheckerCard extends Component
{
    private const TLDS = ['com', 'net', 'org', 'io', 'dev', 'app', 'co'];

    public string $baseDomain = '';
    public bool $loading = false;
    public array $results = [];
    public ?string $error = null;

    #[On('domainSearch')]
    public function startSearch(string $domain): void
    {
        // Strip TLD to get the base label (e.g. "google" from "google.com")
        $parts            = explode('.', strtolower(trim($domain)));
        $this->baseDomain = $parts[0];
        $this->loading    = true;
        $this->results    = [];
        $this->error      = null;
        $this->dispatch('load-bulk-check');
    }

    #[On('load-bulk-check')]
    public function loadBulkCheck(): void
    {
        if (!$this->baseDomain) {
            return;
        }

        $service = app(RdapService::class);

        foreach (self::TLDS as $tld) {
            $domain = $this->baseDomain . '.' . $tld;
            try {
                $result          = $service->checkAvailability($domain);
                $this->results[] = [
                    'tld'        => '.' . $tld,
                    'domain'     => $domain,
                    'registered' => $result['registered'],
                    'expires'    => $result['expires'],
                    'error'      => false,
                ];
            } catch (\Throwable) {
                $this->results[] = [
                    'tld'        => '.' . $tld,
                    'domain'     => $domain,
                    'registered' => null,
                    'expires'    => null,
                    'error'      => true,
                ];
            }
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.bulk-checker-card');
    }
}
