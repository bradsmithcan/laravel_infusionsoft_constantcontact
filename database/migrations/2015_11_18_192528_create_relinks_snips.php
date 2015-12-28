<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelinksSnips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relink_snips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('parent_id');
            $table->string('page_url');
            $table->string('short_link');
            $table->string('title');
            $table->text('descrip');
            $table->integer('api');
            $table->string('upload_path');
            $table->string('bg');
            $table->string('type');
            $table->string('btntxt');
            $table->string('btnurl');
            $table->string('title_color');
            $table->string('descrip_color');
            $table->string('btntxt_color');
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
        Schema::drop('relink_snips');
    }
}
