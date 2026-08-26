<?php

namespace VC\Http\Middleware;

use VC\Http\Request;
use VC\Http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $next): Response;    
}