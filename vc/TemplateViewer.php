<?php

namespace VC;

use VC\TemplateViewerInterface;

class TemplateViewer implements TemplateViewerInterface {

	public function render( string $template, array $data = [] ): string {

		$viewsDir = dirname(__DIR__) . "/views/";

		$code = file_get_contents($viewsDir . $template . '.view.php');

		if (preg_match('#<vc-(?<dir>[\w-]+)\.(?<file>[\w-]+)>(?<content>.*?)</vc-\1\.\2>#s', $code, $matches) === 1) {
			$dir = $matches['dir'] ?? '';
			$file = $matches['file'];
			$wrapper = file_get_contents($viewsDir . $dir . $file . '.view.php');
		}
		// zip content into wrapper, go by zipped code, replace including parts actual code
		// think over passing :data="$data"
		
		$code = $this->escape($code);

		$code = $this->derectives($code);

		extract($data, EXTR_SKIP);

		ob_start();

		eval("?>$code");

		return ob_get_clean();

	}

	public function escape(string $code): string {
		return preg_replace("#\{\{\s*(.+?)\s*\}\}#", "<?= htmlspecialchars( $1, ENT_QUOTES, 'UTF-8' ); ?>", $code);
	}

	public function derectives(string $code): string
	{
		$code = preg_replace(
			"#@(if|elseif|foreach|for|while)\s*\((.*)\)#",
			"<?php \$1 (\$2): ?>",
			$code
		);

		$code = preg_replace('#@else\b#', '<?php else: ?>', $code);

		$code = preg_replace(
			"#@(endif|endforeach|endfor|endwhile)#",
			"<?php \$1; ?>",
			$code
		);

		return $code;
	}
}