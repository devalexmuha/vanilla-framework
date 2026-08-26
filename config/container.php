<?php

use VC\Container;

$container = new Container();

$host = env('DB_HOST');
$name = env('DB_NAME');
$user = env('DB_USER');
$pass = env('DB_PASS');

$container->set( App\Database::class, fn () => new App\Database( $host, $name, $user, $pass ) );
$container->set( VC\Request::class, fn () => VC\Request::createFromGlobals() );

return $container;