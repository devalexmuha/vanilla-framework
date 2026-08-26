<?php

declare( strict_types=1 );

namespace VC;

interface ViewerInterface
{
    public function render(string $template, array $data = []): string;    
}