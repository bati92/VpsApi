<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_communication_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('data_id');
            $table->integer('user_id');
            $table->foreign('data_id')->references('id')->on('datas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('price');
            $table->string('mobile');
            $table->integer('count');
            $table->string('note')->nullable();
            
            $table->string('status')->nullable()->default('قيد المراجعة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_orders');
    }
};
