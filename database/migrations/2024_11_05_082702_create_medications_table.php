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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity')->default(0); // كمية الأدوية المتاحة في المخزون
            $table->string('type'); // نوع الدواء
            $table->date('expiry_date'); // تاريخ انتهاء صلاحية الدواء
            $table->text('description')->nullable(); // وصف الدواء
            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
