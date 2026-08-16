<?php

use App\Controllers\PagesController;
use App\Controllers\ServicesController;
use App\Core\Dispatcher;
use App\Core\Router;

require_once( './inc/all.inc.php' );
$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

$router = new Router();
$router->add( '/', [ PagesController::class, 'renderHome' ] );
$router->add( '/blog', [ PagesController::class, 'renderArchive' ] );
$router->add( '/blog/{slug}', [ PagesController::class, 'renderSingle' ] );

$router->add( '/services', [ ServicesController::class, 'renderArchive' ] );
$router->add( '/services/{slug}', [ ServicesController::class, 'renderSingle' ] );

$router->add( '/blog/create', [ PagesController::class, 'create' ] );
$router->add( '/{test1}/{test2}/{test3}', [ PagesController::class, 'test' ] );
$router->add( '/blog/{id}/edit', [ PagesController::class, 'edit' ] );
$router->add( '/blog/{id}/delete', [ PagesController::class, 'delete' ] );

$router->add( '/{controller}/{id}/{method}' );
$router->add( '/{controller}/{method}' );


$dispatcher = new Dispatcher($router);
$dispatcher->handle($path);