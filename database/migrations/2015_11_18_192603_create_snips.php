<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->string('page_url');
            $table->integer('domain_id');
            $table->integer('service_id');
            $table->string('title');
            $table->string('snip_type');
            $table->text('message');
            $table->text('snip_remarketing_code');
            $table->string('button_text');
            $table->string('button_url');
            $table->string('prifile_id');
            $table->integer('clicks');
            $table->integer('conversion');
            $table->string('page_load_time');
            $table->string('date_created');
            $table->string('upload_path');
            $table->string('custom_short_link');
            $table->integer('is_custom_short_link');
            $table->integer('api');
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
        Schema::drop('snips');
    }
}
