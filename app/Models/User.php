<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'password', 'plan_id', 'api_key', 'api_key_last_four'];

    protected $hidden = ['password', 'remember_token', 'api_key'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function usageLogs(): HasMany
    {
        return $this->hasMany(UsageLog::class);
    }

    public function generateApiKey(): string
    {
        $key = 'rdap_' . Str::uuid()->toString();
        $this->api_key = hash('sha256', $key);
        $this->api_key_last_four = substr($key, -4);
        $this->save();

        return $key;
    }

    public function getDailyLimit(): int
    {
        return $this->plan?->daily_limit ?? 2000;
    }

    public function getPlanSlug(): string
    {
        return $this->plan?->slug ?? 'free';
    }
}
