<?php

use Framework\Http\Response;
use Framework\View\Manager;

if (!function_exists('container')) {
    function container(string $alias = null): mixed
    {
        if (is_null($alias)) {
            return \Framework\Container\Container::getInstance();
        }
        return \Framework\Container\Container::getInstance()->fetch($alias);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $uri): void {
        header("Location: {$uri}");
        exit;
    }
}

if (!function_exists('handleView')) {
    function handleView(string $uri, array $data = []): Response {
        return container(Response::class)->content(
            container(Manager::class)
                ->handle($uri, $data));
    }
}