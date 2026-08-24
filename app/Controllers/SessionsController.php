<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\User;
use App\Requests\SessionsRequest;
use VC\Auth;
use VC\Controller;
use VC\Response;
use VC\Session;
use VC\TemplateViewer;

class SessionsController extends Controller {

	public function __construct(
		private readonly User $user,
		TemplateViewer $viewer,
		SessionsRequest $request,
	) {
		$this->setViewer($viewer);
		$this->setRequest($request);
	}

	public function create(): Response {
		if(Session::get('loggedIn')) {
			return $this->redirect('/pages/');
		}
		return $this->view( 'auth.log-in', [] );
	}

	public function store(): Response {
		$requestData = $this->request->validated();
		if (!$requestData) return $this->view( 'auth.log-in', [
			'error' => $this->request->errors('empty'),
			'pageData' => $this->request->post,
		]);


		$email = $requestData['email'];
		$password = $requestData['pass'];

		$user = $this->user->getUser($email);
		if (!$user) return $this->view( 'auth.log-in', [
			'error' => $this->request->errors('failed'),
			'pageData' => $this->request->post,
		]);

		$hash = $user['hash'];

		if (Auth::attempt($password, $hash)) {
			Session::store([
				'id' => $user['id'],
				'name' => $user['name'],
				'email' => $user['email'],
			]);
			return $this->redirect('/pages/');
		}

		return $this->view( 'auth.log-in', [
			'error' => $this->request->errors('failed'),
			'pageData' => $this->request->post,
		]);
	}

	public function destroy(): Response {
		Auth::logout();
		return $this->redirect('/pages/');
	}
}