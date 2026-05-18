<?php

use App\Http\Controllers\Api\V1\AvailabilityController;
use App\Http\Controllers\Api\V1\BulkController;
use App\Http\Controllers\Api\V1\DnsController;
use App\Http\Controllers\Api\V1\DomainController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Webhook — no API key required, signature-verified
Route::post('/webhooks/lemon-squeezy', [WebhookController::class, 'lemonSqueezy'])
    ->withoutMiddleware(['api'])
    ->name('webhooks.lemon-squeezy');

// V1 API — authenticated + rate limited
Route::prefix('v1')->middleware(['auth.api', 'rate.api', 'log.api'])->group(function () {
    Route::get('/domain/{domain}',       [DomainController::class, 'show'])->name('v1.domain');
    Route::get('/dns/{domain}',          [DnsController::class, 'show'])->name('v1.dns');
    Route::get('/availability/{domain}', [AvailabilityController::class, 'show'])->name('v1.availability');
    Route::post('/bulk',                 [BulkController::class, 'check'])->name('v1.bulk');
});
