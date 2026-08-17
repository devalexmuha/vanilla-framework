<?php

declare(strict_types=1);

namespace App\Core;

class View {
	public function render( string $view, array $pageData = [] ): void {
		extract( $pageData );
		ob_start();
		require __DIR__ . '/../../views/' . $view . '.php';

		$contents = ob_get_clean();

		require __DIR__ . '/../../views/layouts/main.view.php';
	}

	public function error(int $code ): void {
		http_response_code( $code );
		$this->render( 'abstract/error.view', [
			'code' => $code,
		] );
		exit();
	}
}

// create view class with possibility to pass data into head and footer
