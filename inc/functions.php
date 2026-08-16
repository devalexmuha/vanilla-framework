<?php

function e( $value ) {
	return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
}


function route_url( array $params ): string {
	return str_replace( '%2F', '/', http_build_query( $params ) );
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

