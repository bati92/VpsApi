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
     Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->enum('item_type', ['apps', 'ecards', 'cards', 'ebanks', 'data_communications', 'games', 'programs']);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('favorites');
    }
    


};
