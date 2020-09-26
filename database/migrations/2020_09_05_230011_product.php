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
            $table->id();
            $table->string('name');
            $table->string('brief',1000);
            $table->integer('quantify')->unsigned();
            $table->timestamps();
            $table->string('status')->default(App\Product::UNAVAILABLE);
           // $table->integer('seller_id');
            $table->string('image');
           // $table->foreign('seller_id')->references('id')->on('user');
            $table->foreignId('seller_id')->constrained('user');
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
        Schema::dropIfExists('product');
    }
}
