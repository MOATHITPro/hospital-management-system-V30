<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the cache table
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Unique key for the cache entry
            $table->mediumText('value'); // Serialized value of the cache entry
            $table->integer('expiration'); // Timestamp for expiration
        });

        // Create the cache_locks table
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Unique key for the lock
            $table->string('owner'); // Owner of the lock (could be a session or user identifier)
            $table->integer('expiration'); // Timestamp for expiration of the lock
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache'); // Drop the cache table if it exists
        Schema::dropIfExists('cache_locks'); // Drop the cache_locks table if it exists
    }
};
