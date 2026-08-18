<?php

declare(strict_types=1);

namespace VC;

class View {
	public function render( string $view, array $pageData = [] ): void {
		extract( $pageData );
		ob_start();
		require __DIR__ . '/../../views/' . $view . '.php';

		$contents = ob_get_clean();

		require __DIR__ . '/../../views/layouts/main.view.php';
	}
}

