<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('brief',1000);
            $table->string('quantify')->unsigned();
            $table->timestamps();
            $table->string('status')->default(App\Product::UNAVAILABLE);
            $table->integer('seller_id')->unsigned();
            $table->string('image');
            $table->foreign('seller_id')->references('id')->on('user');
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
