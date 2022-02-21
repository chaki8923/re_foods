<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIdentityProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('identity_providers', function(Blueprint $table)
		{
			$table->foreign('store_id', '_identity__providers_user_id_foreign')->references('id')->on('stores')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('identity_providers', function(Blueprint $table)
		{
			$table->dropForeign('_identity__providers_user_id_foreign');
		});
	}

}
