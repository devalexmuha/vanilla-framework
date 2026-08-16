<?php

namespace App\Core;

class Dispatcher {

	public function __construct(
		public Router $router
	){}

	public function handle( string $path ): void {

		$params = $this->router->match( $path );

		if ( !$params ) {
			dd( 'Page not found' );
		}

		$class  = $params['controller'];
		$method = $params['method'];

		if ( ! class_exists( $class ) ) {
			exit( "Controller {$class} not found" );
		}

		$controller = new $class();

		if ( ! method_exists( $controller, $method ) ) {
			exit( "Method {$method} not found" );
		}

		$args = $params;
		unset( $args['controller'], $args['method'] );

		$controller->{$method}( ...$args );
	}

}