<?php

use App\Http\Controllers\Api\V1\AvailabilityController;
use App\Http\Controllers\Api\V1\BulkController;
use App\Http\Controllers\Api\V1\DnsController;
use App\Http\Controllers\Api\V1\DomainController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['rapidapi'])->group(function () {
    Route::get('/domain/{domain}',       [DomainController::class, 'show'])->name('v1.domain');
    Route::get('/dns/{domain}',          [DnsController::class, 'show'])->name('v1.dns');
    Route::get('/availability/{domain}', [AvailabilityController::class, 'show'])->name('v1.availability');
    Route::post('/bulk',                 [BulkController::class, 'check'])->name('v1.bulk');
});
