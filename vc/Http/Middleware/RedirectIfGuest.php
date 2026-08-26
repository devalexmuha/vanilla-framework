<?php

namespace VC\Http\Middleware;

use VC\Http\Request;
use VC\Http\Response;
use VC\Session\SessionManager;

class RedirectIfGuest {
	public function __construct( private Response $response ) {
	}

	public function process( Request $request, RequestHandlerInterface $next ): Response {

		if ( ! SessionManager::get( 'loggedIn' ) ) {
			$this->response->redirect( '/log-in/' );
			return $this->response;
		}

		return $next->handle($request);
	}

}