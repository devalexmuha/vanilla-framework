<?php

declare( strict_types=1 );

namespace VC;

abstract class Controller {

	protected Request $request;

	protected ViewerInterface $viewer;

	protected Response $response;

	public function setRequest(Request $request): void
	{
		$this->request = $request; // how construction happens?
	}

	public function setViewer(ViewerInterface $viewer): void
	{
		$this->viewer = $viewer;
	}

	public function setResponse( Response $response ): void {
		$this->response = $response;
	}

	protected function view(string $template, array $data = [], string $layout = 'main'): Response
	{
		$this->response->setBody($this->viewer->render($template, $data, $layout));

		return $this->response;
	}

	protected function redirect(string $url): Response
	{
		$this->response->redirect($url);

		return $this->response;
	}
}