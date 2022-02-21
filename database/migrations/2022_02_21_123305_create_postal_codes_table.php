<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('postal_codes', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('first_code')->unsigned()->index();
			$table->integer('last_code')->unsigned()->index();
			$table->string('prefecture');
			$table->string('city');
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
		Schema::drop('postal_codes');
	}

}
