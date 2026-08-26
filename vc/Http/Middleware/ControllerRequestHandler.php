<?php

declare(strict_types=1);

namespace VC\Http\Middleware;

use VC\Http\Controller;
use VC\Http\Request;
use VC\Http\Response;

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