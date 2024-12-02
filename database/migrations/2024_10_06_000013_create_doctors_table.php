<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->foreign('specialty')->references('name')->on('specialties')->onDelete('restrict');
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            $table->string('username')->unique(); // Unique username
            $table->string('email')->unique(); // Unique email address
            $table->string('password'); // Password (hashed)
            $table->rememberToken();

            $table->integer('experience');
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column for soft deletes



            $table->unique(['email', 'deleted_at'], 'unique_email')->whereNull('deleted_at');
            $table->unique(['username', 'deleted_at'], 'unique_username')->whereNull('deleted_at');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
