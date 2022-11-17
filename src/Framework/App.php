<?php

namespace Framework;

use Framework\Http\Request;
use Framework\Router\Router;

class App
{
    private static ?App $instance = null;

    public const CONFIG_PATH  = __DIR__ . '/Config/';
    public const CONFIG_FRAMEWORK_DI_KEY = 'CONFIG_DI';
    private const CONFIG_FRAMEWORK_DI_FILE = 'DIInstancesConf';
    public const CONFIG_FRAMEWORK_DB_KEY = 'CONFIG_DB';
    private const CONFIG_FRAMEWORK_DB_FILE = 'DBConf';
    private const CONFIG_FRAMEWORK_CONTROLLERS_FILE = 'RegisterControllers';

    private array $appConf = [];


    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
            return static::$instance;
        }
        return static::$instance;
    }

    private function __construct(){}
    private function __clone(): void{}


    public function run():string
    {
        $this->boostrap();

        $request = container()->fetch(Request::class);
        $router = container()->fetch(Router::class);

        return $router->resolve($request);
    }

    private function boostrap(): void
    {
        $this->loadAppConfiguration();
        $this->registerInstancesIntoContainer();
        $this->registerControllers();
        $this->createRequest();
    }

    private function loadAppConfiguration(): void
    {
        $this->loadFromFile(self::CONFIG_FRAMEWORK_DI_KEY, self::CONFIG_FRAMEWORK_DI_FILE);
        $this->loadFromFile(self::CONFIG_FRAMEWORK_DB_KEY, self::CONFIG_FRAMEWORK_DB_FILE);
    }

    private function loadFromFile(string $configKey, string $filepath): void
    {
        $this->appConf[$configKey] = require self::CONFIG_PATH . $filepath . '.php';
    }

    private function registerInstancesIntoContainer(): void
    {
        $container = \container();
        foreach ($this->appConf[self::CONFIG_FRAMEWORK_DI_KEY] as $i)
        {
            $container->register($i, $i);
        }
    }

    private function createRequest(): void
    {
        $request = \container()->fetch(Request::class);
        $request->method($_SERVER['REQUEST_METHOD']);
        $request->uri($_SERVER['REQUEST_URI']);
    }

    private function registerControllers(): void
    {
        $path = __DIR__ . '/../../config/' . self::CONFIG_FRAMEWORK_CONTROLLERS_FILE . '.php';
        $data = require $path;

        $router = container()->fetch(Router::class);

        foreach ($data as $methodUri => $controller) {
            $router->register($methodUri, new $controller);
        }
    }

}