<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{

    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->integer('population')->nullable(); // إضافة حقل لعدد السكان
        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
