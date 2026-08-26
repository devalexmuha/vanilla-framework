<?php

declare( strict_types=1 );

require_once( './../vendor/autoload.php' );

define( 'ROOT_PATH', dirname( __DIR__ ) );

$dotenv = Dotenv\Dotenv::createImmutable( ROOT_PATH );
$dotenv->load();

set_error_handler( "VC\Exceptions\ErrorHandler::handleError" );
set_exception_handler( "VC\Exceptions\ErrorHandler::handleException" );

\VC\Session\SessionManager::startSession();

$router    = require_once ROOT_PATH . '/routes/web.php';
$container = require_once ROOT_PATH . '/config/container.php';
$middleware = require_once ROOT_PATH . '/config/middleware.php';

$dispatcher = new \VC\Routing\Dispatcher( $router, $container, $middleware );

$request = \VC\Http\Request::createFromGlobals();
$response = $dispatcher->handle($request);
$response->send();