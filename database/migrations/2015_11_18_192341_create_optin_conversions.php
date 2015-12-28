<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptinConversions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('optin_conversions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversion_id');
            $table->integer('snip_id');
            $table->text('snip_url');
            $table->integer('conversions');
            $table->string('conversion_ip');
            $table->string('email');
            $table->string('date');
            $table->string('day');
            $table->string('month');
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
        Schema::drop('optin_conversions');
    }
}
