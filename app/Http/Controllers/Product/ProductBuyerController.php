<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Product $product)
	{
		$buyers = $product
			->transactions()
			->with('buyer')
			->get()
			->pluck('buyer')
			->unique('id')
			->values();
		return $this->showAll($buyers);
	}
}
