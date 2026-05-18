<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => 'Free',     'slug' => 'free',     'price' => 0,    'daily_limit' => 2000],
            ['name' => 'Starter',  'slug' => 'starter',  'price' => 400,  'daily_limit' => 50000],
            ['name' => 'Pro',      'slug' => 'pro',      'price' => 1400, 'daily_limit' => 500000],
            ['name' => 'Business', 'slug' => 'business', 'price' => 3900, 'daily_limit' => -1],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
