<?php

namespace VC;

use VC\Request;
use VC\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}