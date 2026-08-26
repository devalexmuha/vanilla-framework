<?php

declare( strict_types=1 );

require_once( './../vendor/autoload.php' );

define( 'ROOT_PATH', dirname( __DIR__ ) );

$dotenv = Dotenv\Dotenv::createImmutable( ROOT_PATH );
$dotenv->load();

set_error_handler( "VC\ErrorHandler::handleError" );
set_exception_handler( "VC\ErrorHandler::handleException" );

VC\Auth::startSession();

$router    = require_once ROOT_PATH . '/routes/web.php';
$container = require_once ROOT_PATH . '/config/container.php';
$middleware = require_once ROOT_PATH . '/config/middleware.php';

$dispatcher = new VC\Dispatcher( $router, $container, $middleware );

$request = VC\Request::createFromGlobals();
$response = $dispatcher->handle($request);
$response->send();

// guest and auth make as build in options
// csrf make as by default
// add to every body text in the end
// add to every post test
// add @csrf in template
// test cross site scripting
// change sessions id when logged out