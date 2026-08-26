<?php

declare( strict_types=1 );

namespace VC;

class MiddlewareRequestHandler implements RequestHandlerInterface {
	public function __construct(
		private array $middlewares,
		private readonly ControllerRequestHandler $controllerHandler
	) {
	}

	public function handle( Request $request ): Response {
		$middleware = array_shift( $this->middlewares );

		if ( $middleware === null ) {

			return $this->controllerHandler->handle( $request );

		}

		return $middleware->process( $request, $this );
	}
}