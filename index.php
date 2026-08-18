<?php

declare( strict_types=1 );

require_once ('./vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

set_error_handler("VC\ErrorHandler::handleError");
set_exception_handler("VC\ErrorHandler::handleException");

$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
if( $path === false ) {
	throw new UnexpectedValueException("Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'");
}

$router = require_once './routes/web.php';
$container = require_once './config/container.php';

$dispatcher = new VC\Dispatcher( $router, $container );
$dispatcher->handle( $path );