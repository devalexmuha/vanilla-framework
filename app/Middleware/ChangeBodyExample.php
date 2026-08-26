<?php

namespace App\Middleware;

use VC\Http\Middleware\MiddlewareInterface;
use VC\Http\Middleware\RequestHandlerInterface;
use VC\Http\Request;
use VC\Http\Response;

class ChangeBodyExample implements MiddlewareInterface {

	public function __construct(private Response $response) {}

	public function process( Request $request, RequestHandlerInterface $next ): Response {
		$response = $next->handle($request);

		$response->setBody($response->getBody() . " hello from the middleware");

		return $response;
	}
}