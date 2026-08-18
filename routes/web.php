<?php


use App\Controllers\PagesController;
use App\Controllers\ServicesController;
use VC\Router;

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

return $router;