<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\Page;
use VC\View;

class PagesController extends AbstractPagesController {

	public function __construct( private View $view, private Page $page ) {
	}

	public function renderHome(): void {
		$this->view->render( 'pages/home.view', [] );
	}

	public function renderArchive(): void {
		$archiveData = $this->page->getAll();
		$this->view->render( 'pages/archive.view', [
			'archiveData' => $archiveData
		] );
	}

	public function renderSingle( $slug ): void {
		$this->view->render( 'pages/single.view', [
			'slug' => $slug,
		] );
	}

	public function create(): void {
		$this->view->render( 'pages/create.view', [] );
	}

	public function edit( $id ): void {
		$this->view->render( 'pages/edit.view', [
			'id' => $id,
		] );
	}

	public function delete( $id ): void {
		$this->view->render( 'pages/delete.view', [
			'id' => $id,
		] );
	}
}