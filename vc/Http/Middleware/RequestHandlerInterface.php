<?php

namespace VC\Http\Middleware;

use VC\Http\Request;
use VC\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}