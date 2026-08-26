<?php

namespace VC\Http\Middleware;

use VC\Http\Request;
use VC\Http\Response;
use VC\Session\Auth;

class VerifyCsrf implements MiddlewareInterface {
	public function __construct( private Response $response ) {
	}

	public function process( Request $request, RequestHandlerInterface $next ): Response {
		if ( empty( $request->post ) ) {
			return $next->handle( $request );
		}

		$token = $request->post[ 'csrf_token'] ?? '';
		if ( ! Auth::verifyCsrf( $token ) ) {
			$this->response->redirect( '/' );

			return $this->response;
		}
		return $next->handle( $request );
	}
}