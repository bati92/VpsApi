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
        Schema::create('transfer_money_firms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iban');
            $table->string('note')->nullable();
            $table->string('account_name');
            $table->string('image')->nullable();
            $table->string('image_url')->nullable();
 
 
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_money_firms');
    }
};
