<?php

namespace Framework;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Middleware\Middleware;
use Framework\Providers\ViewHandlersProvider;
use Framework\Router\Router;
use Framework\View\Manager;

class App
{
    private static ?App $instance = null;

    public CONST CONFIG_PATH  = __DIR__ . '/Config/';
    public CONST CONFIG_FRAMEWORK_DI_KEY = 'CONFIG_DI';
    private CONST CONFIG_FRAMEWORK_DI_FILE = 'DIInstancesConf';
    public CONST CONFIG_FRAMEWORK_DB_KEY = 'CONFIG_DB';
    private CONST CONFIG_FRAMEWORK_DB_FILE = 'DBConf';
    private CONST CONFIG_FRAMEWORK_CONTROLLERS_FILE = 'RegisterControllers';
    private CONST CONFIG_FRAMEWORK_MIDDLEWARE_FILE = 'MiddlewareHandlersConfig';

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
        session_start();

        $this->boostrap();

        $request = container(Request::class);
        $router = container(Router::class);

        $middleware = container(Middleware::class);
        $request = $middleware->run($request);

        $response =  $router->resolve($request);
        return $this->handleResponse($response);
    }

    private function boostrap(): void
    {
        $this->loadAppConfiguration();
        $this->registerInstancesIntoContainer();
        $this->addProvidersToManagers();
        $this->registerControllers();
        $this->createRequest();
        $this->registerMiddlewares();
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

    private function registerControllers(): void
    {
        $path = __DIR__ . '/../../config/' . self::CONFIG_FRAMEWORK_CONTROLLERS_FILE . '.php';
        $data = require $path;

        $router = container(Router::class);

        foreach ($data as $methodUri => $controller) {
            $router->register($methodUri, new $controller);
        }
    }

    private function addProvidersToManagers(): void
    {
        \container(Manager::class)->getHandlersFromProvider(new ViewHandlersProvider());
    }

    private function createRequest(): void
    {
        $request = \container(Request::class);
        $request->method($_SERVER['REQUEST_METHOD']);
        $request->uri($_SERVER['REQUEST_URI']);

        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $request->addPostParam($key, $value);
            }
        }

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];
            $request->jwtToken($token);
        }

        $body = file_get_contents('php://input');
        if (!empty($body)) {
            $requestData = json_decode($body, true);
            foreach ($requestData as $key => $value) {
                $request->addPostParam($key, $value);
            }
        }
    }

    private function handleResponse(Response $response): string
    {
        header("HTTP/1.1 {$response->statusCode()} {$response->statusCodeMessage()}");

        if (!empty($response->headers())) {
            foreach ($response->headers() as $key => $value) {
                header("{$key}: {$value}");
            }
        }

        return $response->content();
    }

    private function registerMiddlewares(): void
    {
        $path = self::CONFIG_PATH . self::CONFIG_FRAMEWORK_MIDDLEWARE_FILE . '.php';
        $data = require $path;

        $middleware = \container(Middleware::class);

        foreach ($data as $handler) {
            $middleware->pipe(new $handler);
        }
    }
}