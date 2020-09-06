<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction',function(Blueprint $t){
            $t->increments('id')->unsigned();
            $t->timestamps();
            $t->integer('quantify')->unsigned();
            $t->integer('buyer_id')->unsigned();
            $t->integer('product_id')->unsigned();

            $t->foreignId('buyer_id')->references('id')->on('user');
            $t->foreign('product_id')->references('id')->on('product');
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
