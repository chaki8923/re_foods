<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserIdToStoreIdOnIdentityProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identity_providers', function (Blueprint $table) {
            $table->renameColumn('user_id', 'store_id');//<-記述
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('identity_providers', function (Blueprint $table) {
            $table->renameColumn('store_id', 'user_id');//<-記述
        });
    }
}
