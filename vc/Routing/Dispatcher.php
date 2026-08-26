<?php

declare( strict_types=1 );

namespace VC\Routing;

use UnexpectedValueException;
use VC\Container\Container;
use VC\Exceptions\PageNotFoundException;
use VC\Http\Middleware\ControllerRequestHandler;
use VC\Http\Middleware\MiddlewareRequestHandler;
use VC\Http\Request;
use VC\Http\Response;
use VC\View\RawViewer;
use VC\View\TemplateViewer;

class Dispatcher {

	public function __construct(
		private readonly Router $router,
		private readonly Container $container,
		private readonly array $middlewareConfig
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

	protected function getPath( $uri ): string {
		$path = parse_url( $uri, PHP_URL_PATH );

		if ( $path === false ) {
			throw new PageNotFoundException( "Malformed URL:
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

	private function getMiddleware( array $params ): array {

		$middleware = array_filter( array_values( array_unique( [ 'csrf', ...explode( "|", $params["middleware"] ) ] ) ) );

		$base = $this->middlewareBase();

		array_walk( $middleware, function ( &$value ) use ( $base ) {

			if ( ! array_key_exists( $value, $base ) ) {

				throw new UnexpectedValueException( "Middleware '$value' not found in config settings" );

			}

			$value = $this->container->get( $base[ $value ] );

		} );

		return $middleware;
	}

	private function middlewareBase(): array {
		return [
			"csrf"  => \VC\Http\Middleware\VerifyCsrf::class,
			"auth"  => \VC\Http\Middleware\RedirectIfGuest::class,
			"guest" => \VC\Http\Middleware\RedirectIfAuth::class,
			...$this->middlewareConfig,
		];
	}
}