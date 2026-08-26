<?php

return [
    "auth" => \App\Middleware\RedirectIfGuest::class,
    "guest" => \App\Middleware\RedirectIfAuth::class,
];