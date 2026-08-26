<?php

namespace VC\Http\Middleware;

use VC\Http\Request;
use VC\Http\Response;
use VC\Session\SessionManager;

class RedirectIfAuth implements MiddlewareInterface{

	public function __construct( private readonly Response $response ) {
	}

	public function process(Request $request, RequestHandlerInterface $next): Response {

		if ( SessionManager::get( 'loggedIn' ) ) {
			$this->response->redirect( '/pages/' );
			return $this->response;
		}

		return $next->handle($request);
	}

}