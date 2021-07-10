<?php

namespace App\Transformers;

use App\Model\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
	public function transform(Buyer $buyer)
	{
		// quitamos administrador por que es irrelevante para el comprador
		return [
			'referencia' => (int) $buyer->id,
			'nombre' => (string) $buyer->name,
			'correo' => (string) $buyer->email,
			'verificado' =>
				(bool) $buyer->verified === true
					? 'verificado'
					: 'no verificado',
			'fechaCreacion' => (string) $buyer->created_at,
			'fechaActualizacion' => (string) $buyer->update_at,
			'fechaEliminacion' => isset($buyer->delete_at)
				? (string) $buyer->delete_at
				: null,
		];
	}
}
