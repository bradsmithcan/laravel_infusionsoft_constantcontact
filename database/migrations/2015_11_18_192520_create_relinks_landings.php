<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelinksLandings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relink_landings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rid');
            $table->string('ip');
            $table->integer('count');
            $table->double('date');
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
        Schema::drop('relink_landings');
    }
}
