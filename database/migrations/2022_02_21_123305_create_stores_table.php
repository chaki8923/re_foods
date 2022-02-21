<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('store_name');
			$table->integer('post_number')->nullable();
			$table->string('tell_number')->nullable();
			$table->string('store_image');
			$table->timestamps();
			$table->string('email')->unique();
			$table->string('password');
			$table->string('comment');
			$table->dateTime('last_accessed_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stores');
	}

}
