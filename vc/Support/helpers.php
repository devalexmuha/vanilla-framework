<?php
if ( ! function_exists( 'e' ) ) {
	function e( $value ) {
		return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'route_url' ) ) {
	function route_url( array $params ): string {
		return str_replace( '%2F', '/', http_build_query( $params ) );
	}
}
if ( ! function_exists( 'dd' ) ) {
	function dd( ...$vars ): never {
		foreach ( $vars as $var ) {
			echo '<pre style="background:#1a1a1a;color:#e6e6e6;padding:1rem;'
			     . 'border-radius:8px;font-size:14px;line-height:1.5;overflow:auto;">';
			var_dump( $var );
			echo '</pre>';
		}
		die( 1 );
	}
}


if ( ! function_exists( 'env' ) ) {
	function env( string $key): mixed {

		if ( ! isset( $_ENV[ $key ] ) ) {
			return null;
		}

		$value = $_ENV[ $key ];

		return match ( strtolower( $value ) ) {
			'true' => true,
			'false' => false,
			'null' => null,
			'empty', '""' => '',
			default => $value,
		};
	}
}

