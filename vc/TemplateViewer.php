<?php

declare( strict_types=1 );

namespace VC;

use VC\TemplateViewerInterface;
use VC\Session;

class TemplateViewer implements TemplateViewerInterface {

	public function render( string $template, array $data = [] ): string {

		$viewsDir = dirname( __DIR__ ) . "/resources/views";
		if ( str_contains( $template, '.' ) ) {
			$template = str_replace( '.', '/', $template );
		}

		$code = file_get_contents( $viewsDir . '/' . $template . '.view.php' );

		if ( preg_match( '#<vc-(?<dir>[\w-]+)\.(?<file>[\w-]+)>(?<content>.*?)</vc-\1\.\2>#s', $code,
				$matches ) === 1 ) {

			$componentsDir = $viewsDir . '/components';

			$dir     = $matches['dir'];
			$file    = $matches['file'];
			$content = $matches['content'];
			$wrapper = file_get_contents( $componentsDir . '/' . $dir . '/' . $file . '.view.php' );
			$code    = preg_replace( "#\{\{\s*view\s*\}\}#", $content, $wrapper );
			$code = $this->getBlocks( $code, $componentsDir );
		}

		$code = $this->escape( $code );

		$code = $this->directives( $code );

		extract( $data, EXTR_SKIP );

		ob_start();

		eval( "?>$code" );

		return ob_get_clean();

	}

	public function escape( string $code ): string {
		return preg_replace( "#\{\{\s*(.+?)\s*\}\}#", "<?= htmlspecialchars( $1, ENT_QUOTES, 'UTF-8' ); ?>", $code );
	}

	public function directives( string $code ): string {
		$code = preg_replace(
			"#@(if|elseif|foreach|for|while)\s*\((.*)\)#",
			"<?php \$1 (\$2): ?>",
			$code
		);

		$code = preg_replace( '#@else\b#', '<?php else: ?>', $code );

		$code = preg_replace(
			"#@(endif|endforeach|endfor|endwhile)#",
			"<?php \$1; ?>",
			$code
		);

		return $code;
	}

	public function getBlocks( string $code, string $componentsDir ): string {
		if ( preg_match_all( '#<vc-(?<dir>[\w-]+)\.(?<file>[\w-]+)/>#s', $code, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$dir       = $match['dir'];
				$file      = $match['file'];
				$component = file_get_contents( $componentsDir . '/' . $dir . '/' . $file . '.view.php' );
				$code      = preg_replace( "#<vc-$dir\.$file/>#", $component, $code );
			}
			$code = $this->getBlocks( $code, $componentsDir );
		}
		return $code;
	}
}

