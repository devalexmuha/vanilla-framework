<?php

declare(strict_types=1);

use App\Controllers\PagesController;
use App\Controllers\ServicesController;
use App\Core\Container;
use App\Core\Dispatcher;
use App\Core\Router;
use App\Core\View;

require_once( './inc/all.inc.php' );
$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

$router = new Router();
$router->add( '/', [ PagesController::class, 'renderHome' ] );
$router->add( '/blog', [ PagesController::class, 'renderArchive' ] );
$router->add( '/blog/{slug}', [ PagesController::class, 'renderSingle' ] );

$router->add( '/services', [ ServicesController::class, 'renderArchive' ] );
$router->add( '/services/{slug}', [ ServicesController::class, 'renderSingle' ] );

$router->add( '/blog/create', [ PagesController::class, 'create' ] );
$router->add( '/blog/{id}/edit', [ PagesController::class, 'edit' ] );
$router->add( '/blog/{id}/delete', [ PagesController::class, 'delete' ] );

$router->add( '/{controller}/{id}/{method}' );
$router->add( '/{controller}/{method}' );

$container = new Container();

$container->set(App\Database::class, function() {

	return new App\Database("localhost", "framework", "framework", "W-9lZIgjE]p_tKM5");

});


$view = new View();
$dispatcher = new Dispatcher($router, $view, $container);
$dispatcher->handle($path);