<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Model\Category;

class CategoryBuyerController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Category $category)
	{
		$buyer = $category
			->product()
			->whereHas('transactions')
			->with('transactions.buyer')
			->get()
			->pluck('transactions')
			->collapse()
			->pluck('buyer')
			->unique('id')
			->values();
		return $this->showAll($buyer);
	}
}
