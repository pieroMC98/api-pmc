<?php

namespace App\Http\Controllers\Category;

use App\Traits\ApiResponser;
use App\Model\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
	use ApiResponser;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$categoria = Category::all();
		return $this->showAll($categoria);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$rules = ['name' => 'required', 'brief' => 'required'];
		$this->validate($request, $rules);
		$categoria = Category::create($request->all());
		return $this->showOne($categoria, 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function show(Category $category)
	{
		return $this->showOne($category);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Category $category)
	{
		// al menos uno de ellos y diferente al original
		$category->fill($request->only(['name', 'brief']));
		//clean: verifica que no ha cambiado, isdirty: verifica que ha cambaido
		if ($category->isClean()) {
			return $this->errorResponse(
				'Debe de actualizar al menos un valor',
				422
			);
		}

		// HTMLMETHOD:PUT. no se puede usar form-data, en vez x-www-form-urlencoded
		$category->save();
		return $this->showOne($category);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Category $category)
	{
		$category->delete();
		return $this->showOne($category);
	}
}
