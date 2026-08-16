<?php

namespace App\Controllers;

abstract class AbstractPagesController {
	protected function render( string $view, array $pageData = [] ): void {
		extract( $pageData );
		ob_start();
		require __DIR__ . '/../../views/' . $view . '.php';

		$contents = ob_get_clean();

		require __DIR__ . '/../../views/layouts/main.view.php';
	}

	protected function error404() {
		http_response_code( 404 );
		$this->render( 'abstract/error.view', [] );
		exit();
	}
}