<?php

use VC\Container;

$container = new Container();

$host = env('DB_HOST');
$name = env('DB_NAME');
$user = env('DB_USER');
$pass = env('DB_PASS');

$container->set( App\Database::class, fn () => new App\Database( $host, $name, $user, $pass ) );
$container->set( App\Requests\PagesRequest::class, fn () => App\Requests\PagesRequest::createFromGlobals() );
$container->set( App\Requests\SessionsRequest::class, fn () => App\Requests\SessionsRequest::createFromGlobals() );

return $container;