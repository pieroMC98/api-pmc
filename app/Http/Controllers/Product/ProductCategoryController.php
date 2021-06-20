<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $p)
    {
		$categories = $p->category;
		return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, Category $category)
    {
		// muchos a muchos: sync, attach, syncwithoutdataching
		$product->category()->syncWithoutDetaching([$category->id]);
		return $this->showAll($product->category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
