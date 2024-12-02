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
        Schema::create('pharmacy_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->onDelete('cascade');
            $table->foreignId('pharmacy_id')
                ->constrained('pharmacies')
                ->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->enum('status', ['Pending', 'Done', 'Cancelled','Completed'])->default('Pending');
            $table->dateTime('estimated_pickup_time')->nullable(); // الوقت المتوقع للاستلام
            $table->text('pharmacy_notes')->nullable(); // ملاحظات الصيدلية
            $table->timestamps();
            $table->softDeletes();
        });
    }
        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_appointments');
    }
};
