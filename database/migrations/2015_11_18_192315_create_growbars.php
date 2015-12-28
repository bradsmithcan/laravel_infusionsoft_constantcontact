<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrowbars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('growbars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('website');
            $table->text('link_url');
            $table->string('openin');
            $table->text('headline');
            $table->text('link_text');
            $table->string('font_family');
            $table->string('background_color');
            $table->string('text_color');
            $table->string('action_color');
            $table->string('action_text_color');
            $table->string('position');
            $table->string('size');
            $table->tinyInteger('animate');
            $table->tinyInteger('wiggle');
            $table->tinyInteger('hidebar');
            $table->tinyInteger('push');
            $table->integer('clicks');
            $table->integer('conversion');
            $table->timestamp('date_created');
            $table->integer('parent');
            $table->text('cdbg');
            $table->text('cdtext');
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
        Schema::drop('growbars');
    }
}
