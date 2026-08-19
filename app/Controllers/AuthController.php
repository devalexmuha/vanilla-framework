<?php

declare(strict_types=1);

namespace App\Controllers;

use VC\View;

class AuthController {

	public function __construct(private View $view) {}

	public function renderLogIn(): void {
		$this->view->render( 'auth/log-in.view', [] );
	}
}