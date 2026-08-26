<?php

namespace VC\Middleware;

use VC\Auth;
use VC\MiddlewareInterface;
use VC\Request;
use VC\RequestHandlerInterface;
use VC\Response;

class VerifyCsrf implements MiddlewareInterface {
	public function __construct( private Response $response ) {
	}

	public function process( Request $request, RequestHandlerInterface $next ): Response {
		$token = $request->post['csrf'];
		if ( ! Auth::verifyCsrf( $token ) ) {
			$this->response->setStatusCode( 403 );
			$this->response->redirect('/pages/');
			return $this->response;
		}
		return $next->handle( $request );
	}
}