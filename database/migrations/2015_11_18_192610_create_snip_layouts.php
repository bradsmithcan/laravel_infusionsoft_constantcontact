<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnipLayouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snip_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('snip_id');
            $table->integer('user_id');
            $table->string('background_color');
            $table->string('text_color');
            $table->string('action_color');
            $table->text('action_text_color');
            $table->text('theme');
            $table->string('position');
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
        Schema::drop('snip_layouts');
    }
}
