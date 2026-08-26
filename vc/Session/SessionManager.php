<?php

declare( strict_types=1 );

namespace VC\Session;

class SessionManager {


	public static function startSession(): void {
		if ( session_status() === PHP_SESSION_NONE ) {
			session_start();
		}
	}

	public static function store( array $sessionData ): void {
		static::startSession();
		foreach ( $sessionData as $name => $value ) {
			$_SESSION[ $name ] = $value;
		}

	}

	public static function get( string $name ) {
		return $_SESSION[ $name ] ?? null;
	}

	public static function getCsrf(): string {
		if ( empty( static::get( 'csrf' ) ) ) {
			static::store( [
				'csrf' => bin2hex( random_bytes( 32 ) )
			] );
		}

		return static::get( 'csrf' );
	}
}