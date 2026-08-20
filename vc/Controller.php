<?php

declare(strict_types=1);

namespace VC;


abstract class Controller
{
    protected Request $request;

    protected View $view;

	protected function setRequest(Request $request): void
    {
        $this->request = $request;
    }

	protected function setView(View $view): void
    {
        $this->view = $view;
    }
}