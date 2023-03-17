<?php

const ROUTES = [
    // chaque clé correspond au nom d'une route.
    'home' => [
        'controller' => App\Controller\MainController::class,
        'method' => 'home'
    ],
    'inscription' => [
        'controller' => App\Controller\ConnectController::class,
        'method' => 'inscription'
    ],
    'login' => [
        'controller' => App\Controller\ConnectController::class,
        'method' => 'login'
    ],
];