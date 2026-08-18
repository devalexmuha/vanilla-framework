<?php

declare(strict_types=1);

namespace VC;

class Router {
	private array $routes = [];

	public function add( string $path, array $params = [] ): void {
		if ( ! empty( $params ) ) {
			$this->routes[ $path ] = [
				'controller' => $params[0],
				'method'     => $params[1],
			];

			return;
		}
		$this->routes[ $path ] = [];
	}

	public function match( string $path ): bool|array {
		$routes = $this->sortRoutes();
		$path = strtolower(trim($path, '/'));
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

	private function sortRoutes(): array {
		$routes = $this->routes;
		uksort( $routes, fn( $a, $b ) => $this->literalCount( $b ) <=> $this->literalCount( $a ) );

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

}