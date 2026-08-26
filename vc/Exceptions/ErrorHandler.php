<?php

declare( strict_types=1 );

namespace VC\Exceptions;

use ErrorException;
use Throwable;

class ErrorHandler {

	public static function handleError(
		int $errno,
		string $errstr,
		string $errfile,
		int $errline
	): void {
		throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
	}

	public static function handleException( Throwable $exception ): void {
		$showErrors = env('ERR_SHOW');
		$writeLog   = env('ERR_LOG');


		$statusCode = $exception instanceof PageNotFoundException ? 404 : 500;
		http_response_code( $statusCode );


		if ( $writeLog && ! ( $exception instanceof PageNotFoundException ) ) {
			error_log( (string) $exception );
		}


		if ( $showErrors ) {
			echo "<pre>{$exception}</pre>";
		} else {
			require __DIR__ . "/../View/views/errors/error.view.php";
		}

	}
}