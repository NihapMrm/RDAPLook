<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('endpoint', 100);
            $table->string('domain', 253)->nullable();
            $table->unsignedSmallInteger('response_time_ms')->nullable();
            $table->unsignedSmallInteger('status_code');
            $table->timestamp('created_at')->useCurrent()->index();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_logs');
    }
};
