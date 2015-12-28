<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_user');
            $table->string('twitter_id');
            $table->string('facebook_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->string('homeurl');
            $table->string('activation_code');
            $table->tinyInteger('resent')->unsigned();
            $table->integer('activation')->default(0);
            $table->integer('archive');
            $table->string('profile_count');
            $table->string('friends_count');
            $table->string('first');
            $table->string('last');
            $table->integer('paid');
            $table->integer('type');
            $table->string('p_reset');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
