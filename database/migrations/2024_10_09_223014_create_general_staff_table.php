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
        Schema::create('general_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('clinic_id');
            $table->integer('experience');
            $table->softDeletes();

            $table->timestamps();



            $table->unique(['email', 'deleted_at'], 'unique_email')->whereNull('deleted_at');
            $table->unique(['username', 'deleted_at'], 'unique_username')->whereNull('deleted_at');

            // Foreign key reference to clinics table
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_staff');
    }
};
