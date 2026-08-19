<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\Page;
use VC\View;

class PagesController {

	public function __construct( private View $view, private Page $page ) {
	}

	public function renderHome(): void {
		$this->view->render( 'pages/home.view', [], 'home' );
	}

	public function renderArchive(): void {
		$pageData = $this->page->getAll();
		$this->view->render( 'pages/archive.view', [
			'pageData' => $pageData,
		] );
	}

	public function renderSingle( $slug ): void {
		$pageData = $this->page->getByCol('slug', $slug);
		$this->view->render( 'pages/single.view', [
			'pageData' => $pageData,
		] );
	}

	public function create(): void {
		$this->view->render( 'pages/create.view', [] );
	}

	public function edit( $id ): void {
		$pageData = $this->page->getById($id);
		$this->view->render( 'pages/edit.view', [
			'pageData' => $pageData,
		] );
	}
//
//	public function delete( $id ): void {
//		$this->view->render( 'pages/delete.view', [
//			'id' => $id,
//		] );
//	}
}