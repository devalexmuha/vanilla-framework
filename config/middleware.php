<?php

return [
    "auth" => \VC\Middleware\RedirectIfGuest::class,
    "guest" => \VC\Middleware\RedirectIfAuth::class,
];