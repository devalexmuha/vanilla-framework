<?php

declare(strict_types=1);

namespace VC;

class RawViewer {
	public function render( string $view, array $pageData = [], string $layout = 'main' ): void {

		if ( str_contains( $view, '.' ) ) {
			$view = str_replace( '.', '/', $view );
		}

		extract( $pageData );
		ob_start();
		require dirname(__DIR__) . '/resources/views/' . $view . '.view.php';

		$contents = ob_get_clean();

		require dirname( __DIR__ ) . '/resources/views/components/layouts/' . $layout . '.view.php';
	}
}

