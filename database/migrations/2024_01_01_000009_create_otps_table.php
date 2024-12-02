<?php

// CreateOtpsTable.php (Migration)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
public function up()
{
    Schema::create('otps', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->string('otp_code');
        $table->unsignedInteger('attempts')->default(0);
        $table->timestamp('expires_at');
        $table->json('data')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
