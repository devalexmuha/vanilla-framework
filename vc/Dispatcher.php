<?php

declare( strict_types=1 );

namespace VC;

use BadMethodCallException;
use VC\MiddlewareRequestHandler;
use InvalidArgumentException;
use UnexpectedValueException;
use VC\Exceptions\PageNotFoundException;

class Dispatcher {

	public function __construct(
		private readonly Router $router,
		private readonly Container $container,
		private array $middlewareConfig
	) {
	}

	public function handle( Request $request ): Response {

		$path = $this->getPath( $request->uri );

		$params = $this->router->match( $path, $request->method );

		if ( ! $params ) {
			throw new PageNotFoundException( "No route match the path: $path with method $request->method." );
		}

		$className = $params['controller'];
		$method    = $params['method'];

		if ( ! class_exists( $className ) ) {
			throw new PageNotFoundException( "Controller {$className} not found" );
		}

		$controller = $this->container->get( $className );
		$controller->setResponse( $this->container->get( Response::class ) );
		$controller->setViewer( $this->container->get( $this->getViewer() ) );

		if ( ! method_exists( $controller, $method ) ) {
			throw new PageNotFoundException( "Method {$method} not found" );
		}

		$args = $params;
		unset( $args['controller'], $args['method'], $args['middleware'] );
		$controllerHandler = new ControllerRequestHandler( $controller, $method, $args );

		$middleware = $this->getMiddleware( $params );

		$middlewareHandler = new MiddlewareRequestHandler( $middleware, $controllerHandler );

		return $middlewareHandler->handle( $request );
	}

	private function getMiddleware( array $params ): array {
		if ( empty( $params['middleware'] ) ) {

			return [];

		}

		$middleware = explode( "|", $params["middleware"] );

		array_walk( $middleware, function ( &$value ) {

			if ( ! array_key_exists( $value, $this->middlewareConfig ) ) {

				throw new UnexpectedValueException( "Middleware '$value' not found in config settings" );

			}

			$value = $this->container->get( $this->middlewareConfig[ $value ] );

		} );

		return $middleware;
	}

	protected function getPath( $uri ): string {
		$path = parse_url( $uri, PHP_URL_PATH );

		if ( $path === false ) {
			throw new VC\Exceptions\PageNotFoundException( "Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'" );
		}

		return $path;
	}

	private function getViewer(): string {
		$viewer = env( 'VIEWER' );

		return match ( strtolower( $viewer ) ) {
			'raw' => RawViewer::class,
			default => TemplateViewer::class,
		};
	}
}