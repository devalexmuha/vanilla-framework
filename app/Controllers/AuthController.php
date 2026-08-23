<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\User;
use App\Requests\AuthRequest;
use VC\TemplateViewer;

class AuthController {

	public function __construct(
		private readonly TemplateViewer $view,
		private readonly AuthRequest $request,
		private readonly User $user,
	) {}

	public function create(): void {
		echo $this->view->render( 'auth/log-in.view', [] );
	}
}