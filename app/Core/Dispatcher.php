<?php

declare(strict_types=1);

namespace App\Core;

use ReflectionClass;

class Dispatcher {

	public function __construct(
		private readonly Router $router,
		private readonly View $view,
		private readonly Container $container
	) {
	}

	public function handle( string $path ): void {

		$params = $this->router->match( $path );

		if ( ! $params ) {
			$this->view->error( 404 );
		}

		$className  = $params['controller'];
		$method = $params['method'];

		if ( ! class_exists( $className ) ) {
			exit( "Controller {$className} not found" );
		}

		$controller = $this->container->get( $className );

		if ( ! method_exists( $controller, $method ) ) {
			exit( "Method {$method} not found" );
		}

		$args = $params;
		unset( $args['controller'], $args['method'] );

		$controller->{$method}( ...$args );
	}

}