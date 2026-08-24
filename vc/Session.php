<?php

declare( strict_types=1 );

namespace VC;

class Session {

	public static function store ( array $sessionData): void {
		Auth::startSession();
		foreach ($sessionData as $name => $value) {
			$_SESSION[$name] = $value;
		}

	}

	public static function get (string $name) {
		return $_SESSION[$name] ?? null;
	}

}