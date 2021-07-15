<?php

namespace App\Transformers;

use App\Model\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
	public function transform(Seller $seller)
	{
		// quitamos administrador por que es irrelevante para el comprador
		return [
			'referencia' => (int) $seller->id,
			'nombre' => (string) $seller->name,
			'correo' => (string) $seller->email,
			'verificado' =>
				(bool) $seller->verified === true
					? 'verificado'
					: 'no verificado',
			'fechaCreacion' => (string) $seller->created_at,
			'fechaActualizacion' => (string) $seller->update_at,
			'fechaEliminacion' => isset($seller->delete_at)
				? (string) $seller->delete_at
				: null,
		];
	}
	static function attributesLabels($input)
	{
		$original = [
			'id' => 'referencia',
			'name' => 'nombre',
			'email' => 'correo',
			'verified' => 'verificado',
			'created_at' => 'fechaCreacion',
			'update_at' => 'fechaActualizacion',
			'delete_at' => 'fechaEliminacion',
		];
		return isset(($rt = $original[$input])) ? $rt : null;
	}
}
