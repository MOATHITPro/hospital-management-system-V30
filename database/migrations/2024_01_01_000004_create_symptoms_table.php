<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Column for the name of the symptom
            $table->boolean('is_emergency')->default(false); // Column indicating if the symptom is an emergency
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('symptoms'); // Drop the symptoms table if it exists
    }
};
