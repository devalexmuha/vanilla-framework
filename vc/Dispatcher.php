<?php

declare(strict_types=1);

namespace VC;

use BadMethodCallException;
use InvalidArgumentException;
use VC\Exceptions\PageNotFoundException;

class Dispatcher {

	public function __construct(
		private readonly Router $router,
		private readonly Container $container
	) {
	}

	public function handle( string $path ): void {

		$params = $this->router->match( $path );

		if ( ! $params ) {
			throw new PageNotFoundException("No route match the path: $path");
		}

		$className  = $params['controller'];
		$method = $params['method'];

		if ( ! class_exists( $className ) ) {
			throw new InvalidArgumentException( "Controller {$className} not found" );
		}

		$controller = $this->container->get( $className );

		if ( ! method_exists( $controller, $method ) ) {
			throw new BadMethodCallException( "Method {$method} not found" );
		}

		$args = $params;
		unset( $args['controller'], $args['method'] );

		$controller->{$method}( ...$args );
	}

}