<?php

declare( strict_types=1 );

namespace App\Controllers;

use App\Model\User;
use VC\Auth;
use VC\Controller;
use VC\Response;
use VC\Session;

class SessionsController extends Controller {

	public function __construct( private readonly User $user ) {
	}

	public function create(): Response {
		if ( Session::get( 'loggedIn' ) ) {
			return $this->redirect( '/pages/' );
		}

		return $this->view( 'auth.log-in', [] );
	}

	public function store(): Response {

		$requestData = $this->request->post;

		if ( $userData = $this->user->getUser( $requestData ) ) {

			if ( Auth::attempt( $requestData['pass'], $userData['hash'] ) ) {
				Session::store( [
					'id'    => $userData['id'],
					'name'  => $userData['name'],
					'email' => $userData['email'],
				] );

				return $this->redirect( '/pages/' );

			}

			$this->user->addError( "failed", "Your input does not match our records" );

		}

		$errors = $this->user->getErrors();

		return $this->view( 'auth.log-in', [
			'error'    => $errors['failed'] ?? $errors['empty'],
			'pageData' => $this->request->post,
		] );
	}

	public function destroy(): Response {

		Auth::logout();

		return $this->redirect( '/pages/' );

	}
}