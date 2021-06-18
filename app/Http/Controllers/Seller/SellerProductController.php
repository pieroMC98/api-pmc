<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Model\Seller;
use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Product;

class SellerProductController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Seller $seller)
	{
		return $this->showAll($seller->product);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, User $seller)
	{
		$rules = [
			'name' => 'required',
			'brief' => 'required',
			'quantify' => ['required', 'integer', 'min:1'],
			'image' => 'required|image',
		];

		$this->validate($request, $rules);
		$data = $request->all();
		$data['status'] = Product::UNAVAILABLE;
		$data['image'] = '1.jpg';
		$data['seller_id'] = $seller->id;

		$product = Product::create($data);
		return $this->showOne($product);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Model\Seller  $seller
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Seller $seller, Product $product)
	{
		$rules = [
			'quantify' => ['integer', 'min:1'],
			'status' => [
				'in:' . Product::AVAILABLE . ',' . Product::UNAVAILABLE,
			],
			'image' => 'image',
		];

		if ($seller->id != $product->seller_id) {
			return $this->errorResponse(
				'El vendedor no es el vendedor real del producto',
				422
			);
		}

		$this->validate($request, $rules);

		$product->fill($request->intersect(['name', 'brief', 'quantify']));

		if ($request->has('status')) {
			$product->status = $request->status;
			if (
				$product->is_available() &&
				$product->category()->count() == 0
			)
				return $this->errorResponse(
					'Un producto activo debe tener al menos una categoria',
					409
				);
		}

		if( $product->isClean() )
				return $this->errorResponse(
					'Se debe especificar al menos un valor diferente para actualizar',
					422);
		$product->save();
		return $this->showOne($product);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Model\Seller  $seller
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Seller $seller)
	{
		//
	}
}
