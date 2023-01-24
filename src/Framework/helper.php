<?php

declare(strict_types=1);

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

if (!function_exists('configs')) {
    function configs(string $key): int|array|string
    {
        $configs = require __DIR__ . '/Config/Config.php';
        return $configs[$key];
    }
}

if (!function_exists('dbconn')){
    function dbconn(): PDO
    {
        // TODO: get configuration from ENV and not configs
        // TODO: search a way to use constants for matching config properties
        $user = configs('database.user');
        $password = configs('database.password');
        $host = configs('database.host');
        $port = configs('database.port');
        $dbname = configs('database.dbname');
        $dsn="mysql:host={$host};dbname={$dbname}";
        return new PDO($dsn, $user, $password);
        // mysql:host=localhost;port=3307;dbname=testdb
    }
}