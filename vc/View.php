<?php

declare(strict_types=1);

namespace VC;

class View {
	public function render( string $view, array $pageData = [] ): void {
		extract( $pageData );
		ob_start();
		require dirname(__DIR__) . '/resources/views/' . $view . '.php';

		$contents = ob_get_clean();

		require dirname(__DIR__) . '/resources/views/layouts/main.view.php';
	}
}

