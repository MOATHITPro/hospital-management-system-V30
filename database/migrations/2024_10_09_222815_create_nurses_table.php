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
        Schema::create('nurses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->unsignedBigInteger('clinic_id');
            $table->integer('experience');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('Permissions',["none",'normal', 'vaccine', 'medicine'])->default('none');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();


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
        Schema::dropIfExists('nurses');
    }
};
