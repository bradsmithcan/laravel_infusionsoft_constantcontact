<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tid');
            $table->string('item_name');
            $table->string('payer_email');
            $table->string('first_name');
            $table->string('last_name');
            $table->float('amount');
            $table->string('currency');
            $table->string('country');
            $table->string('txn_type');
            $table->string('payer_id');
            $table->string('payment_status');
            $table->string('payment_type');
            $table->dateTime('create_date');
            $table->dateTime('payment_date');
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
        Schema::drop('orders');
    }
}
