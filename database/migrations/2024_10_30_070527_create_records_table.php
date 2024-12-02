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
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('event_type', 255)->index();
            $table->unsignedBigInteger('entity_id')->index();
            $table->string('entity_type', 255)->index();
            $table->enum('action', ['create', 'update', 'delete', 'restore'])->index();
            $table->text('description')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamp('occurred_at')->useCurrent()->index();


            $table->enum('status', ['unread', 'read', 'archived'])->default('unread')->index();

            $table->timestamps();
            $table->softDeletes();


            // Composite Index
            $table->index(['entity_type', 'entity_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
