<?php

namespace App\Middleware;

use VC\Http\Middleware\MiddlewareInterface;
use VC\Http\Middleware\RequestHandlerInterface;
use VC\Http\Request;
use VC\Http\Response;

class ChangeInputExample implements MiddlewareInterface {
	public function process( Request $request, RequestHandlerInterface $next ): Response {

		if(!empty($request->post['name'])){
			$request->post['name'] .= 'hi there';
		}

		return $next->handle($request);
	}
}