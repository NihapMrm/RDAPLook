<?php

namespace App\Livewire;

use App\Services\RdapService;
use Livewire\Attributes\On;
use Livewire\Component;

class AvailabilityCard extends Component
{
    public string $domain = '';
    public bool $loading = false;
    public ?array $result = null;
    public ?string $error = null;

    #[On('domainSearch')]
    public function startSearch(string $domain): void
    {
        $this->domain = $domain;
        $this->loading = true;
        $this->result = null;
        $this->error = null;
        $this->dispatch('load-availability');
    }

    #[On('load-availability')]
    public function loadAvailability(): void
    {
        if (!$this->domain) {
            return;
        }

        try {
            $this->result = app(RdapService::class)->checkAvailability($this->domain);
        } catch (\Throwable) {
            $this->error = 'Availability check failed';
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.availability-card');
    }
}
