<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID

            // User's personal information
            $table->string('first_name'); // First name
            $table->string('last_name'); // Last name
            $table->string('username')->unique(); // Unique username
            $table->string('email')->unique(); // Unique email address
            $table->string('password'); // Password (hashed)
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade'); // Foreign key to cities
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade'); // Foreign key to districts
            $table->date('date_of_birth'); // Date of birth
            $table->string('id_number')->unique(); // Unique ID number
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Adds deleted_at column for soft deletes



            $table->unique(['email', 'deleted_at'], 'unique_email')->whereNull('deleted_at');
            $table->unique(['username', 'deleted_at'], 'unique_username')->whereNull('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop users table if it exists
    }
}
