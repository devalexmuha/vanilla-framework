<?php

declare( strict_types=1 );

namespace App\Controllers;

use App\Model\Page;
use VC\Http\Controller;
use VC\Http\Response;

class PagesController extends Controller {

	public function __construct( private readonly Page $page ) {
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
		$pageData = $this->page->getByCol( 'slug', $slug );

		return $this->view( 'pages.single', [
			'pageData' => $pageData,
		] );
	}

	public function create(): Response {
		return $this->view( 'pages.create', [] );
	}

	public function store(): Response {

		$requestData = $this->request->post;

		if ( $this->page->insert( $requestData ) ) {

			return $this->redirect( '/pages/' );

		}

		return $this->view( 'pages.create', [
			'error'    => $this->page->getErrors()['name'],
			'pageData' => $requestData,
		] );

	}

	public function edit( $id ): Response {
		$pageData = $this->page->getById( $id );

		return $this->view( 'pages.edit', [
			'pageData' => $pageData,
		] );
	}

	public function update( $id ): Response {

		$requestData = $this->request->post;

		if ( $this->page->update( $id, $requestData ) ) {
			$pageData                = $this->page->getById( $id );
			return $this->redirect( "/page/{$pageData['slug']}" );

		}
		$pageData                = $this->page->getById( $id );
		$pageData['name']        = $this->request->post['name'] ?? '';
		$pageData['description'] = $this->request->post['description'] ?? '';

		return $this->view( 'pages.edit', [
			'error'    => $this->page->getErrors()['name'],
			'pageData' => $pageData,
		] );
	}


	public function destroy( $id ): Response {
		$this->page->delete( $id );

		return $this->redirect( '/pages/' );
	}
}