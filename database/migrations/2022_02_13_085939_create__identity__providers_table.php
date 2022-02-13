<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentityProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_identity__providers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('stores'); // 外部キー制約
            $table->string('provider_id');
            $table->string('provider_name');
            $table->primary(['provider_name', 'provider_id']); // 複合キー
            $table->unique(['user_id', 'provider_name']); // ユニーク制限
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
        Schema::dropIfExists('_identity__providers');
    }
}
