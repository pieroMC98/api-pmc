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
            $t->id();
            $t->timestamps();
            $t->integer('quantify')->unsigned();
            $t->unsignedBigInteger('buyer_id');
            $t->unsignedBigInteger('product_id');

            $t->foreign('buyer_id')->references('id')->on('user');
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
        Schema::dropIfExists('transaction');
    }
}
