<?php

declare( strict_types=1 );

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

	public function handle( Request $request ): void {

		$path = $this->getPath();

		$params = $this->router->match( $path, $request->method );

		if ( ! $params ) {
			throw new PageNotFoundException( "No route match the path: $path" );
		}

		$className = $params['controller'];
		$method    = $params['method'];

		if ( ! class_exists( $className ) ) {
			throw new PageNotFoundException( "Controller {$className} not found" );
		}

		$controller = $this->container->get( $className );

		if ( ! method_exists( $controller, $method ) ) {
			throw new PageNotFoundException( "Method {$method} not found" );
		}

		$args = $params;
		unset( $args['controller'], $args['method'] );

		$controller->{$method}( ...$args );
	}

	protected function getPath(): string {
		$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

		if ( $path === false ) {
			throw new VC\Exceptions\PageNotFoundException( "Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'" );
		}

		return $path;
	}
}