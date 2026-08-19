<?php


use App\Controllers\AuthController;
use App\Controllers\PagesController;
use VC\Router;

$router = new Router();
$router->add( '/', [ PagesController::class, 'renderHome' ] );
$router->add( '/pages/', [ PagesController::class, 'renderArchive' ] );
$router->add( '/page/{slug}/', [ PagesController::class, 'renderSingle' ] );
$router->add( '/page/create/', [ PagesController::class, 'create' ] );
$router->add( '/page/{id}/edit/', [ PagesController::class, 'edit' ] );

$router->add( '/log-in/', [ AuthController::class, 'renderLogIn' ] );

return $router;