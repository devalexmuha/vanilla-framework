<?php

namespace VC;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $next): Response;    
}