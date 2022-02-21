<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('identity_providers', function(Blueprint $table)
		{
			$table->bigInteger('store_id')->unsigned();
			$table->string('provider_id');
			$table->string('provider_name');
			$table->timestamps();
			$table->primary(['provider_name','provider_id']);
			$table->unique(['store_id','provider_name'], '_identity__providers_user_id_provider_name_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('identity_providers');
	}

}
