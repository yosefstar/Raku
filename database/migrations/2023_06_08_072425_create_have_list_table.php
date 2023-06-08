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
            $table->unsignedBigInteger('user_id'); // 追加されたカラム
            $table->timestamps();
            $table->string('have_status')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 外部キー制約
            $table->foreign('itemCode')->references('itemCode')->on('item_list')->onDelete('cascade'); // 外部キー制約
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
