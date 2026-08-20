<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\Page;
use App\Requests\PagesRequest;
use VC\Controller;
use VC\View;

class PagesController extends Controller {

	public function __construct(
		private Page $page,
		PagesRequest $request,
		View $view,
	) {
		$this->setRequest($request);
		$this->setView($view);
	}

	public function showHome(): void {
		$this->view->render( 'pages/home.view', [], 'home' );
	}

	public function showArchive(): void {
		$pageData = $this->page->getAll();
		$this->view->render( 'pages/archive.view', [
			'pageData' => $pageData,
		] );
	}

	public function showSingle( $slug ): void {
		$pageData = $this->page->getByCol('slug', $slug);
		$this->view->render( 'pages/single.view', [
			'pageData' => $pageData,
		] );
	}

	public function create(): void {
		$this->view->render( 'pages/create.view', [] );
	}

	public function store(): void {
		$requestData = $this->request->validated();
		if ($requestData) {

			$data = [
				'slug' => $requestData['slug'],
				'name' => $requestData['name'],
				'description' => $requestData['description'] ?? null,
			];

			$this->page->insert($data);
			header('Location: /pages/');
			exit();
		}
		$this->view->render( 'pages/create.view', ['error' => $this->request->errors()] );

	}

	public function edit( $id ): void {
		$pageData = $this->page->getById($id);
		$this->view->render( 'pages/edit.view', [
			'pageData' => $pageData,
		] );
	}

	public function update($id): void {
		dd($_POST, 'hi there');
	}

	public function destroy($id): void {
		dd($_POST);
	}
//
//	public function delete( $id ): void {
//		$this->view->render( 'pages/delete.view', [
//			'id' => $id,
//		] );
//	}
}