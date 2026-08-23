<?php

namespace VC;

interface TemplateViewerInterface
{
    public function render(string $template, array $data = []): string;    
}