<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Model\Category;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Category $category)
	{
		$sellers = $category
			->product()
			->with('seller')
			->get()
			->pluck('seller')
			->unique('id')
			->values();
		return $this->showAll($sellers);
	}
}
