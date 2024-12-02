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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();


//            $table->enum('appointment_type',);

            // Foreign Keys
            $table->foreignId('patient_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('doctor_id')
                ->constrained('doctors') // or 'users' if doctors are stored there
                ->onDelete('cascade');

            $table->foreignId('time_id')
                ->constrained('time_slots')
                ->onDelete('cascade');

            // Appointment Details
            $table->date('appointment_date');
            // If you need to store time as well, consider using dateTime
//             $table->dateTime('appointment_datetime');

            $table->enum('status', ['Pending', 'Done', 'Cancelled','Completed',"ToPharmacy"])->default('Pending');
            $table->enum('type', ['normal', 'vaccine', 'medicine'])->default('normal');
            $table->text('notes')->nullable();
//            $table->unique(['appointment_date', 'time_id', 'doctor_id'], 'unique_pending_status')
//                ->whereIn('status', ['Pending', 'Done','Completed',"ToPharmacy"]);
//

            $table->softDeletes();



            // Timestamps and Soft Deletes
            $table->timestamps();

            // Indexes for frequently queried columns
            $table->index('appointment_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
