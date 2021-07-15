<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	//public $preserveKeys = true;
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'referencia' => (int) $this->id,
			'nombre' => (string) $this->name,
			'correo' => (string) $this->email,
			'verificado' => (int) $this->verified,
			'administrador' => $this->admin === 'true', // de la BD recibimos cadena, por lo que parseamdo
			'fechaCreacion' => (string) $this->created_at,
			'fechaActualizacion' => (string) $this->updated_at,
			'fechaEliminacion' => isset($this->delete_at)
				? (string) $this->delete_at
				: null,
		];
	}
}
