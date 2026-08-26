<?php

use VC\Container\Container;

$container = new Container();

$host = env('DB_HOST');
$name = env('DB_NAME');
$user = env('DB_USER');
$pass = env('DB_PASS');

$container->set( App\Database::class, fn () => new App\Database( $host, $name, $user, $pass ) );
$container->set( \VC\Http\Request::class, fn () => \VC\Http\Request::createFromGlobals() );

return $container;