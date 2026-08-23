<?php

declare(strict_types=1);

namespace VC;


abstract class Controller
{
    protected Request $request;

    protected RawViewer $view;

	protected function setRequest(Request $request): void
    {
        $this->request = $request;
    }

	protected function setView(RawViewer $view): void
    {
        $this->view = $view;
    }
}