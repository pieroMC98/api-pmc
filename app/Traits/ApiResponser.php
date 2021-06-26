<?php
// sensitive case!!!
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($msg, $code)
	{
		return response()->json(['error' => $msg, 'code' => $code], $code);
	}

	protected function showAll(Collection $c, $code = 200)
	{
		return $this->successResponse(['data' => $c], $code);
	}

	protected function showOne(Model $c, $code = 200)
	{
		return $this->successResponse(['data' => $c], $code);
	}

	protected function showMsg($c, $code = 200)
	{
		return $this->successResponse(['data' => $c], $code);
	}
}
