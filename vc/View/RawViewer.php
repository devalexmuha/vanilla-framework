<?php

declare( strict_types=1 );

namespace VC\View;

class RawViewer implements ViewerInterface {

	public function render( string $view, array $data = [], string $layout = 'main' ): string {

		if ( str_contains( $view, '.' ) ) {
			$view = str_replace( '.', '/', $view );
		}

		extract( $data, EXTR_SKIP );

		ob_start();
		require dirname( __DIR__ ) . '/resources/views/' . $view . '.view.php';
		$contents = ob_get_clean();

		ob_start();
		require dirname( __DIR__ ) . '/resources/views/components/layouts/' . $layout . '.view.php';

		return ob_get_clean();
	}
}


