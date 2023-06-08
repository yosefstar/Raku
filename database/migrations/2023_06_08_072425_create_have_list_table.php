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
        Schema::create('have_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imageUrl')->nullable();
            $table->string('itemName')->nullable();
            $table->integer('itemPrice')->nullable();
            $table->string('itemUrl')->nullable();
            $table->string('itemCode')->unique();
            $table->timestamps();
            $table->string('have_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('have_list');
    }
};
