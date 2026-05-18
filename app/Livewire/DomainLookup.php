<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class DomainLookup extends Component
{
    private const ANON_DAILY_LIMIT = 10;

    private const LUA_INCR_EXPIRE = <<<'LUA'
        local n = redis.call('INCR', KEYS[1])
        if n == 1 then
            redis.call('EXPIREAT', KEYS[1], ARGV[1])
        end
        return n
        LUA;

    public string $query = '';
    public string $error = '';
    public bool $searched = false;

    public function search(): void
    {
        $input = trim($this->query);

        $validDomain = preg_match(
            '/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
            $input
        );
        $validIp = preg_match('/^(\d{1,3}\.){3}\d{1,3}$/', $input);

        if (!$validDomain && !$validIp) {
            $this->error = 'Please enter a valid domain name (e.g. google.com)';
            return;
        }

        if (!$this->checkAnonRateLimit()) {
            $this->error = 'Free lookup limit reached. Get a free API key for 2,000 requests/day.';
            return;
        }

        $this->error = '';
        $this->searched = true;
        $this->dispatch('domainSearch', domain: $input);
    }

    private function checkAnonRateLimit(): bool
    {
        $ip      = request()->ip();
        $date    = now()->utc()->format('Y-m-d');
        $key     = 'anon_rate:' . $ip . ':' . $date;
        $resetAt = now()->utc()->endOfDay()->timestamp;

        $used = (int) Redis::eval(self::LUA_INCR_EXPIRE, 1, $key, $resetAt);

        return $used <= self::ANON_DAILY_LIMIT;
    }

    public function render()
    {
        return view('livewire.domain-lookup');
    }
}
