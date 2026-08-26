<?php

declare( strict_types=1 );

namespace VC;

class Router {
	private array $getRoutes = [];
	private array $postRoutes = [];

	private string $currentGroupMiddleware = '';

	public function group( string $middleware, callable $callback ): void {
		$this->currentGroupMiddleware = $middleware;
		$callback( $this );
	}

	public function get( string $path, array $params = [] ): void {
		$this->getRoutes[ $path ] = [
			'controller' => $params[0] ?? null,
			'method'     => $params[1] ?? null,
			'middleware' => $this->currentGroupMiddleware,
		];
	}

	public function post( string $path, array $params = [] ): void {
		$this->postRoutes[ $path ] = [
			'controller' => $params[0] ?? null,
			'method'     => $params[1] ?? null,
			'middleware' => $this->currentGroupMiddleware,
		];
	}

	public function match( string $path, string $request ): bool|array {
		$routes = $this->sortRoutes( $request );

		$path   = strtolower( trim( $path, '/' ) );
		foreach ( $routes as $route => $params ) {

			$pattern = $this->getThePattern( $route );

			if ( preg_match( $pattern, $path, $args ) ) {
				$args = isset( $args[1] ) ? $this->buildArgsArr( $route, $args ) : [];

				return [
					...$params,
					...$args,
				];
			}

		}

		return false;
	}

	private function sortRoutes( string $request ): array {
		if ( $request === 'POST' ) {
			$routes = $this->postRoutes;
		} else {
			$routes = $this->getRoutes;
		}
		uksort( $routes, fn( $a, $b ) => $this->literalCount( $b ) <=> $this->literalCount( $a ) ); // b -> a descending

		return $routes;
	}

	private function literalCount( string $route ): int {
		$parts = explode( '/', trim( $route, '/' ) );

		return count( array_filter( $parts, function ( $p ) {
			return ! str_contains( $p, '{' );
		} ) );
	}


	private function getThePattern( $route ): string {

		$parts = explode( '/', trim( $route, '/' ) );
		$parts = array_map( function ( $part ) {

			if ( preg_match( '/\{[a-zA-Z0-9-_]+\}/', $part ) ) {
				return '([a-zA-Z0-9-_]+)';
			}


			return $part;
		}, $parts );

		return '#^' . implode( '\/', $parts ) . '$#';
	}

	private function buildArgsArr( string $route, array $args ): array {

		preg_match_all( '#\{([a-zA-Z0-9-_]+)\}#', $route, $names );

		$values = array_slice( $args, 1 );

		$result = array_combine( $names[1], $values );

		if ( isset( $result['controller'] ) ) {
			$result['controller'] = $this->buildControllerClass( $result['controller'] );
		}

		return $result;
	}

	private function buildControllerClass( string $name ): string {
		return '\\App\\Controllers\\' . ucfirst( $name ) . 's' . 'Controller';
	}


	public function middleware() {
	}

}