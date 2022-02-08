<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->integer('to_store')->references('id')->on('stores')->onDelete('cascade');
            $table->integer('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->boolean('dclick_flg')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
