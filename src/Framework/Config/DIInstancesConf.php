<?php

/*
 * Framework specific classes to be loaded into the DIContainer
 */
return [
    \Framework\Http\Request::class,
    \Framework\Http\Response::class,
    \Framework\Router\Router::class,
    \Framework\View\Manager::class,
    \Framework\Middleware\Middleware::class
];