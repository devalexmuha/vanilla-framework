<?php

declare( strict_types=1 );

namespace VC;

class Auth {

	public static function startSession(): void {
		if ( session_status() === PHP_SESSION_NONE ) {
			session_start();
		}
	}

	public static function getCsrf(): string {
		if ( empty( Session::get( 'csrf' ) ) ) {
			Session::store( [
				'csrf' => bin2hex( random_bytes( 32 ) )
			] );
		}

		return Session::get( 'csrf' );
	}

	public static function attempt( string $pass, string $hash ): bool {
		if ( password_verify( $pass, $hash ) ) {
			Session::store( [
				'loggedIn' => true
			] );

			return true;
		}

		return false;
	}

	public static function verifyCsrf( string $token ): bool {

		return $token === self::getCsrf();

	}

	public static function logout(): void {
		$_SESSION = [];
		if ( ini_get( "session.use_cookies" ) ) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}
		session_destroy();
	}
}