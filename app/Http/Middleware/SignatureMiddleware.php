<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SignatureMiddleware
{
	/**
	 * Handle an incoming request. Agrega respuesta en las cabeceras.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  $header Cuando no es del estandar HTTP, por convenio a may'uscula.
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next, $header = 'X-Name')
	{
		// si fuera antes ser'ia before middleware
		$response = $next($request);
		$response->headers->set($header, config('app.name'));
		// after middleware, se ejecuta despues de la respuesta
		return $response;
	}
}
