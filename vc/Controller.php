<?php

declare( strict_types=1 );

namespace VC;

abstract class Controller {

	protected Request $request;

	protected TemplateViewerInterface $viewer;

	protected function setRequest(Request $request): void
	{
		$this->request = $request;
	}

	protected function setViewer(TemplateViewerInterface $viewer): void
	{
		$this->viewer = $viewer;
	}

	protected Response $response;

	public function setResponse( Response $response ): void {
		$this->response = $response;
	}

	protected function view(string $template, array $data = []): Response
	{
		$this->response->setBody($this->viewer->render($template, $data));

		return $this->response;
	}

	protected function redirect(string $url): Response
	{
		$this->response->redirect($url);

		return $this->response;
	}
}