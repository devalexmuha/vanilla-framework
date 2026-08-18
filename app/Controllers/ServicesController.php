<?php

declare(strict_types=1);

namespace App\Controllers;

use VC\View;

class ServicesController extends AbstractPagesController {

	public function __construct(private View $view) {}

	public function renderArchive(): void {
		$this->view->render( 'services/archive.view', [] );
	}

	public function renderSingle($slug): void {
		$this->view->render( 'services/single.view', [
			'slug' => $slug,
		] );
	}

	public function create(): void {
		$this->view->render( 'services/create.view', [] );
	}

	public function edit($id): void {
		$this->view->render( 'services/edit.view', [
			'id' => $id,
		] );
	}

	public function delete($id): void {
		$this->view->render( 'services/delete.view', [
			'id' => $id,
		] );
	}
}