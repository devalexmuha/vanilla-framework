<?php

namespace App\Controllers;

use App\Controllers\AbstractPagesController;

class ServicesController extends AbstractPagesController {
	public function renderArchive(): void {
		$this->render( 'services/archive.view', [] );
	}

	public function renderSingle($slug): void {
		$this->render( 'services/single.view', [
			'slug' => $slug,
		] );
	}

	public function create(): void {
		$this->render( 'services/create.view', [] );
	}

	public function edit($id): void {
		$this->render( 'services/edit.view', [
			'id' => $id,
		] );
	}

	public function delete($id): void {
		$this->render( 'services/delete.view', [
			'id' => $id,
		] );
	}
}