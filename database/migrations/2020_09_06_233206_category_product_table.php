<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_product', function (Blueprint $table) {
			$table->unsignedBigInteger('category_id');
			$table->unsignedBigInteger('product_id');
			$table
				->foreign('category_id')
				->references('id')
				->on('category');
			$table
				->foreign('product_id')
				->references('id')
				->on('product');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('category_product');
	}
}
