<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Model\Category;

class CategoryProductController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Category $category)
	{
		$product = $category->product;
		return $this->showAll($product);
	}
}
