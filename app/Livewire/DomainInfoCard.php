<?php

namespace App\Livewire;

use App\Services\DomainNotFoundException;
use App\Services\RdapService;
use App\Services\RdapUnavailableException;
use Livewire\Attributes\On;
use Livewire\Component;

class DomainInfoCard extends Component
{
    public string $domain = '';
    public bool $loading = false;
    public ?array $info = null;
    public ?string $error = null;

    #[On('domainSearch')]
    public function startSearch(string $domain): void
    {
        $this->domain = $domain;
        $this->loading = true;
        $this->info = null;
        $this->error = null;
        $this->dispatch('load-domain-info');
    }

    #[On('load-domain-info')]
    public function loadInfo(): void
    {
        if (!$this->domain) {
            return;
        }

        try {
            $this->info = app(RdapService::class)->lookupDomain($this->domain);
        } catch (DomainNotFoundException|RdapUnavailableException) {
            $this->error = 'Data unavailable for this TLD';
        } catch (\Throwable) {
            $this->error = 'Data unavailable for this TLD';
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.domain-info-card');
    }
}
