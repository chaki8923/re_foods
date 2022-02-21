<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('place')->nullable();
			$table->integer('store_id');
			$table->timestamps();
			$table->string('prefecture')->nullable();
			$table->string('city')->nullable();
			$table->string('address')->nullable();
			$table->integer('first_code')->nullable();
			$table->integer('last_code')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('address');
	}

}
