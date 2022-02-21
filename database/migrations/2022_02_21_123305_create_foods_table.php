<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('foods', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('food_name');
			$table->integer('store_id');
			$table->date('loss_limit');
			$table->integer('plice')->nullable();
			$table->string('pic1');
			$table->string('pic2')->nullable();
			$table->string('pic3')->nullable();
			$table->integer('sub_category_id')->nullable()->default(0);
			$table->string('comment')->nullable();
			$table->timestamps();
			$table->integer('category_id');
			$table->integer('likes');
			$table->boolean('decision_flg')->default(0);
			$table->date('decision_at')->nullable();
			$table->string('address');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('foods');
	}

}
