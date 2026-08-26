<?php

namespace VC\Middleware;

use VC\MiddlewareInterface;
use VC\Request;
use VC\RequestHandlerInterface;
use VC\Response;
use VC\Session;

class RedirectIfAuth implements MiddlewareInterface{

	public function __construct( private readonly Response $response ) {
	}

	public function process(Request $request, RequestHandlerInterface $next): Response {

		if ( Session::get( 'loggedIn' ) ) {
			$this->response->redirect( '/pages/' );
			return $this->response; // find out how this works in a chain
		}

		return $next->handle($request);
	}

}