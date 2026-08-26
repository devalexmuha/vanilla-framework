<?php

declare( strict_types=1 );

namespace VC\Session;

class Auth {

	public static function attempt( string $pass, string $hash ): bool {
		if ( password_verify( $pass, $hash ) ) {
			session_regenerate_id(true);
			SessionManager::store( [
				'loggedIn' => true
			] );

			return true;
		}

		return false;
	}

	public static function verifyCsrf( string $token ): bool {

		return $token === SessionManager::getCsrf();

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