<?php

namespace App\Transformers;

use App\Model\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
	/**
	 * List of resources to automatically include
	 *
	 * @var array
	 */
	protected $defaultIncludes = [
		//
	];

	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected $availableIncludes = [
		//
	];

	/**
	 * A Fractal transformer.
	 *
	 * @return array
	 */
	public function transform(Product $product)
	{
		// quitamos administrador por que es irrelevante para el comprador
		return [
			'referencia' => (int) $product->id,
			'titulo' => (string) $product->name,
			'detalles' => (string) $product->brief,
			'disponible' => (int) $product->quantify,
			'estado' =>
				(bool) $product->status === true
					? 'disponible'
					: 'no disponible',
			'imagen' => url("img/{$product->image}"),
			'vendedor' => (int) $product->seller_id,
			'fechaCreacion' => (string) $product->created_at,
			'fechaActualizacion' => (string) $product->update_at,
			'fechaEliminacion' => isset($product->delete_at)
				? (string) $product->delete_at
				: null,
		];
	}

	static function attributesLabels($input)
	{
		$original = [
			'referencia'=>'id',
			'titulo'=>'name',
			'detalles'=>'brief',
			'disponible'=>'quantify',
			'estado'=>'status',
			'imagen'=>'image',
			'vendedor'=>'seller_id',
			'fechaCreacion'=>'created_at',
			'fechaActualizacion'=>'update_at',
			'fechaEliminacion'=>'delete_at'
		];
		if(isset($original[$input]))
			return $original[$input];
		else
			return null;
	}
}
