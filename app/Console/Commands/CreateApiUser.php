<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateApiUser extends Command
{
    protected $signature   = 'rdap:create-user {email} {--plan=free}';
    protected $description = 'Create an API user and generate their API key';

    public function handle(): int
    {
        $email = $this->argument('email');
        $slug  = $this->option('plan');

        if (User::where('email', $email)->exists()) {
            $this->error("User {$email} already exists.");
            return 1;
        }

        $plan = Plan::where('slug', $slug)->first();

        if (!$plan) {
            $this->error("Plan '{$slug}' not found. Run db:seed first.");
            return 1;
        }

        $user = User::create([
            'email'    => $email,
            'password' => Hash::make(str()->random(32)),
            'plan_id'  => $plan->id,
        ]);

        $apiKey = $user->generateApiKey();

        $this->info("User created successfully.");
        $this->table(
            ['Email', 'Plan', 'API Key'],
            [[$user->email, $plan->name, $apiKey]]
        );
        $this->warn('Store the API key safely — it cannot be recovered.');

        return 0;
    }
}
