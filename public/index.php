<?php

declare( strict_types=1 );

require_once( './../vendor/autoload.php' );

define( 'ROOT_PATH', dirname(__DIR__));

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

set_error_handler("VC\ErrorHandler::handleError");
set_exception_handler("VC\ErrorHandler::handleException");

$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
if( $path === false ) {
	throw new VC\Exceptions\PageNotFoundException("Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'");
}

$router = require_once ROOT_PATH . '/routes/web.php';
$container = require_once ROOT_PATH . '/config/container.php';

$dispatcher = new VC\Dispatcher( $router, $container );
$dispatcher->handle( $path );