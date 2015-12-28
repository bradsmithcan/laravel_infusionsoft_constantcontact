<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('parent_id');
            $table->string('child_name');
            $table->text('child_home_url');
            $table->text('child_pic');
            $table->text('child_pic_resize');
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
        Schema::drop('child_profiles');
    }
}
