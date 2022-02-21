<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecisionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('decisions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('store_id');
			$table->integer('to_store');
			$table->integer('food_id');
			$table->boolean('click_flg')->default(0);
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
		Schema::drop('decisions');
	}

}
