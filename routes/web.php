<?php


use App\Controllers\AuthController;
use App\Controllers\PagesController;
use VC\Router;

$router = new Router();
$router->get( '/', [ PagesController::class, 'showHome' ] );
$router->get( '/pages/', [ PagesController::class, 'showArchive' ] );
$router->get( '/page/{slug}/', [ PagesController::class, 'showSingle' ] );

$router->get( '/page/create/', [ PagesController::class, 'create' ] );
$router->post( '/page/', [ PagesController::class, 'store' ] );

$router->get( '/page/{id}/edit/', [ PagesController::class, 'edit' ] );
$router->post( '/page/{id}/', [ PagesController::class, 'update' ] );
$router->post( '/page/{id}/delete/', [ PagesController::class, 'destroy' ] );

$router->get( '/log-in/', [ AuthController::class, 'create' ] );
$router->post( '/log-in/', [ AuthController::class, 'store' ] );
$router->post( '/log-out/', [ AuthController::class, 'destroy' ] );

return $router;