<?php

namespace App\Controllers;

use App\Controllers\AbstractPagesController;

class PagesController extends AbstractPagesController {

	public function renderHome(): void {
		$this->render( 'pages/home.view', [] );
	}

	public function test($test1, $test2, $test3): void {
		var_dump( $test1 , $test2 , $test3 );
	}

	public function renderArchive(): void {
		$this->render( 'pages/archive.view', [] );
	}

	public function renderSingle($slug): void {
		$this->render( 'pages/single.view', [
			'slug' => $slug,
		] );
	}

	public function create(): void {
		$this->render( 'pages/create.view', [] );
	}

	public function edit($id): void {
		$this->render( 'pages/edit.view', [
			'id' => $id,
		] );
	}

	public function delete($id): void {
		$this->render( 'pages/delete.view', [
			'id' => $id,
		] );
	}
}