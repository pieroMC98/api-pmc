<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Model\Seller;
use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Product;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
		$data['image'] = $request->image->store('');// ya est'a definido en filesystem
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

		$this->verificarVendedor($seller, $product);
		// hacen lo mismo
		$this->validate($request, $rules);
		//$request->validate($rules); // version nueva

		$product->fill($request->only(['name', 'brief', 'quantify']));

		if ($request->has('status')) {
			$product->status = $request->status;
			if (
				$product->is_available() &&
				$product->category()->count() == 0
			) {
				return $this->errorResponse(
					'Un producto activo debe tener al menos una categoria',
					409
				);
			}
		}

		if ($product->isClean()) {
			return $this->errorResponse(
				'Se debe especificar al menos un valor diferente para actualizar',
				422
			);
		}

		$product->save();
		return $this->showOne($product);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Model\Seller  $seller
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Seller $seller, Product $product)
	{
		$this->verificarVendedor($seller, $product);
		$product->delete();
		return $this->showOne($product);
	}

	private function verificarVendedor(Seller $seller, Product $product)
	{
		if ($seller->id != $product->seller_id) {
			throw new HttpException(
				422,
				'El vendedor no es el vendedor real del producto'
			);
		}
	}
}
