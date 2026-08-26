<?php

use App\Controllers\PagesController;
use App\Controllers\SessionsController;
use VC\Routing\Router;

$router = new Router();

$router->get( '/',              [ PagesController::class, 'showHome' ] );
$router->get( '/pages/',        [ PagesController::class, 'showArchive' ] );
$router->get( '/page/{slug}/',  [ PagesController::class, 'showSingle' ] );


$router->group( 'guest', function ( Router $router ) {
	$router->get(  '/log-in/', [ SessionsController::class, 'create' ] );
	$router->post( '/log-in/', [ SessionsController::class, 'store' ] );
} );

$router->group( 'auth', function ( Router $router ) {
	$router->get(  '/page/create/',       [ PagesController::class, 'create' ] );
	$router->post( '/page/',              [ PagesController::class, 'store' ] );
	$router->get(  '/page/{id}/edit/',    [ PagesController::class, 'edit' ] );
	$router->post( '/page/{id}/',         [ PagesController::class, 'update' ] );
	$router->post( '/page/{id}/delete/',  [ PagesController::class, 'destroy' ] );
	$router->post( '/log-out/',           [ SessionsController::class, 'destroy' ] );
} );

return $router;