<?php

namespace App\Requests;

use VC\Request;

class PagesRequest extends Request {

	public function validated(): array|bool {
		if(!empty($this->post['name'])){
			$slug = seoSlug($this->post['name']);
			return [
				'slug' => $slug,
				...$this->post
			];
		}
		return false;
	}

	public function errors(): string {
		return 'Please enter at least a name of page';
	}

}