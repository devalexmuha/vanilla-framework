<?php

declare(strict_types=1);

namespace VC;

use VC\Controller;
use VC\Request;
use VC\RequestHandlerInterface;
use VC\Response;

class ControllerRequestHandler implements RequestHandlerInterface
{
	private array $args;

	public function __construct(private readonly Controller $controller,
                                private readonly string $action,
                                array $args)
    {
	    $this->args = $args;
    }

    public function handle(Request $request): Response
    {
        $this->controller->setRequest($request);

        return ($this->controller)->{$this->action}(...$this->args);
    }
}