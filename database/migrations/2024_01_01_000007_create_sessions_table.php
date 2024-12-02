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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID as the primary key
            $table->foreignId('user_id')->nullable()->index(); // Foreign key to the users table, nullable
            $table->string('ip_address', 45)->nullable(); // IP address of the user (IPv6 compatible)
            $table->text('user_agent')->nullable(); // User agent string for device information
            $table->longText('payload'); // Session data in a serialized format
            $table->integer('last_activity')->index(); // Timestamp of the last activity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions'); // Drop the sessions table if it exists
    }
};
