<?php

namespace App\Requests;

use App\Model\User;;
use VC\Request;

class SessionsRequest extends Request {

	public function validated(): array|bool {
		if(!empty($this->post['email']) && !empty($this->post['pass'])) {

			return [
				'email' => $this->post['email'],
				'pass' => $this->post['pass'],
			];
		}
		return false;
	}

	public function errors($key): string {
		$errors = [
			'empty' => 'Please enter both the email and password',
			'failed' => 'These credentials do not match our records',
		];
		return $errors[$key] ?? 'Check your input';
	}

}