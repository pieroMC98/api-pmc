<?php

namespace App\Transformers;

use App\Model\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
	public function transform(User $user)
	{
		return [
			'referencia' => (int) $user->id,
			'nombre' => (string) $user->name,
			'correo' => (string) $user->email,
			'verificado' => (int) $user->verified,
			'administrador' => $user->admin === 'true', // de la BD recibimos cadena, por lo que parseamdo
			'fechaCreacion' => (string) $user->created_at,
			'fechaActualizacion' => (string) $user->updated_at,
			'fechaEliminacion' => isset($user->delete_at)
				? (string) $user->delete_at
				: null,
		];
	}

	static function originalAttribute($index)
	{
		return null;
	}
}
