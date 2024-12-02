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
        Schema::create('pharmacy_order_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_appointment_id')
                ->constrained('pharmacy_appointments')
                ->onDelete('cascade');
            $table->foreignId('medication_id')
                ->constrained('medications')
                ->onDelete('cascade');
            $table->integer('patient_quantity')->default(1); // الكمية المطلوبة للمريض
            $table->string('dosage')->nullable(); // الجرعة
            $table->string('instructions')->nullable(); // تعليمات خاصة
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_order_medications');
    }
};
