<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmailservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('as_user_services', function ($table) {
            $table->string('compaign_id')->after('list');
            $table->string('app_id')->after('compaign_id');
            $table->string('api_username')->after('app_id');
            $table->string('api_password')->after('api_username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
