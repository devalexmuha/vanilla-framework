<?php

namespace App\Model;

use VC\Model;

class Page extends Model {

	public function validate( array $data ): array|false {

		if ( ! empty( $data["name"] ) ) {

			return [
				'slug'        => seoSlug( $data['name'] ),
				'name'        => $data['name'],
				'description' => $data['description'] ?? null,
			];

		}

		$this->addError( "name", "Name is required" );
		return false;
	}
}