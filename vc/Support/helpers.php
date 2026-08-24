<?php
if ( ! function_exists( 'e' ) ) {
	function e( $value ) {
		return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'routeUrl' ) ) {
	function routeUrl( array $params ): string {
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
	function env( string $key ): mixed {

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

if ( ! function_exists( 'seoSlug' ) ) {
	function seoSlug( string $slug ): string {
		$map  = [
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'ґ' => 'g',
			'д' => 'd',
			'е' => 'e',
			'є' => 'ye',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'y',
			'і' => 'i',
			'ї' => 'yi',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'kh',
			'ц' => 'ts',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'shch',
			'ю' => 'yu',
			'я' => 'ya',
			'ь' => '',
			'ъ' => '',
			'ё' => 'yo',
			'э' => 'e',
			'ы' => 'y',
			'ў' => 'u',
			'љ' => 'lj',
			'њ' => 'nj',
			'ћ' => 'c',
			'ќ' => 'k',
			'ђ' => 'dj',
			'џ' => 'dz',
			'ѕ' => 'dz'
		];
		$slug = trim( $slug );
		$slug = mb_strtolower( $slug, 'UTF-8' );
		$slug = strtr( $slug, $map );
		$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
		$slug = preg_replace( '/-+/', '-', $slug );
		$slug = trim( $slug, '-' );

		return $slug;
	}
}

if ( ! function_exists( 'getCsrf' ) ) {
	function getCsrf(): string {
		return VC\Auth::getCsrf();
	}
}
