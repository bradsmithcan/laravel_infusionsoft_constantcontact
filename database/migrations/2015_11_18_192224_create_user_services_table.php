<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('as_user_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_id');
            $table->integer('user_id');
            $table->string('thekey');
            $table->string('list');
            $table->string('additional');
            $table->integer('done');
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
        Schema::drop('as_user_services');
    }
}
