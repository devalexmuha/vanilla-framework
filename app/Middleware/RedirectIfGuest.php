<?php

namespace App\Middleware;

use VC\Request;
use VC\RequestHandlerInterface;
use VC\Response;
use VC\Session;

class RedirectIfGuest {
	public function __construct( private Response $response ) {
	}

	public function process( Request $request, RequestHandlerInterface $next ): Response {

		if ( ! Session::get( 'loggedIn' ) ) {
			$this->response->redirect( '/log-in/' );
			return $this->response;
		}

		return $next->handle($request);
	}

}