<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Product $product, User $buyer)
	{
		$request->validate(['quantify' => ['required', 'integer', 'min:1']]);

		if ($buyer->id == $product->seller_id) {
			return $this->errorResponse(
				'El comprador debe ser diferente al vendedor',
				409
			);
		}

		if (!$buyer->isVerified()) {
			return $this->errorResponse(
				'El comprador debe ser un usuario verificado',
				409
			);
		}

		if (!$product->seller->isVerified()) {
			return $this->errorResponse(
				'El vendedor debe ser un usuario verificado',
				409
			);
		}

		if (!$product->is_available()) {
			return $this->errorResponse(
				'El producto para esta transactions no esta disponible',
				409
			);
		}

		if ($product->quantify < $request->quantify) {
			return $this->errorResponse(
				'El producto no tiene la cantidad disponible requerida para esta transaction',
				409
			);
		}

		return DB::transactions(function () use ($request, $product, $buyer) {
			$product->quantify -= $request->quantify;
			$product->save();

			$transactions = Transaction::create([
				'quantify' => $request->quantify,
				'buyer_id' => $buyer->id,
				'product_id' => $product->id,
			]);
			return $this->showOne($transactions, 201);
		});
	}
}
