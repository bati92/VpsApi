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
        Schema::create('ecards', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('image');
            $table->integer('price');
            $table->string('note')->nullable();
            $table->integer('ecard_id');
            $table->foreign('ecard_id')->references('id')->on('ecard_sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecards');
    }
};