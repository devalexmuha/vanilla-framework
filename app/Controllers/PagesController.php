<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\Page;
use App\Requests\PagesRequest;
use JetBrains\PhpStorm\NoReturn;
use VC\Controller;
use VC\Response;
use VC\TemplateViewer;

class PagesController extends Controller{

	public function __construct(
		private readonly Page $page,
		PagesRequest $request,
		TemplateViewer $viewer,
	) {
		$this->setRequest($request);
		$this->setViewer($viewer);
	}

	public function showHome(): Response {
		return $this->view( 'pages.home', [] );
	}

	public function showArchive(): Response {
		$pageData = $this->page->getAll();
		return $this->view( 'pages.archive', [
			'pageData' => $pageData,
		] );
	}

	public function showSingle( $slug ): Response {
		$pageData = $this->page->getByCol('slug', $slug);
		return $this->view( 'pages.single', [
			'pageData' => $pageData,
		] );
	}

	public function create(): Response {
		return $this->view( 'pages.create', [] );
	}

	public function store(): Response {
		$requestData = $this->request->validated();
		if ($requestData) {

			$data = [
				'slug' => $requestData['slug'],
				'name' => $requestData['name'],
				'description' => $requestData['description'] ?? null,
			];

			$this->page->insert($data);
			return $this->redirect('/pages/');

		}
		return $this->view( 'pages.create', [
			'error' => $this->request->errors(),
			'pageData' => $_POST,
			]);

	}

	public function edit( $id ): Response {
		$pageData = $this->page->getById($id);
		return $this->view( 'pages.edit', [
			'pageData' => $pageData,
		] );
	}

	public function update($id): Response {
		$requestData = $this->request->validated();
		if ($requestData) {

			$data = [
				'slug' => $requestData['slug'],
				'name' => $requestData['name'],
				'description' => $requestData['description'] ?? null,
			];

			$this->page->update($id, $data);
			return $this->redirect("/page/{$data['slug']}");

		}
		$pageData = $this->page->getById($id);
		$pageData['name']        = $this->request->post['name'] ?? '';
		$pageData['description'] = $this->request->post['description'] ?? '';

		return $this->view( 'pages.edit', [
			'error'    => $this->request->errors(),
			'pageData' => $pageData,
		] );
	}


	public function destroy($id): Response {
		$this->page->delete($id);
		return $this->redirect('/pages/');
	}
}