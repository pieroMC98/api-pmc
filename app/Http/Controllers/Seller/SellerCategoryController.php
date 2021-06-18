<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Model\Seller;

class SellerCategoryController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Seller $s)
	{
		$categories = $s
			->product()
			->with('categories')
			->get()
			->pluck('categories')
			->collapse()
			->unique('id')
			->values();

		return $this->showAll($categories);
	}
}
