<?php

namespace Unit\Framework\Router;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Router\Router;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    public function testRouterExist(): void
    {
        $router = new Router();
        $this->assertNotNull($router, 'Router class does not exist');
    }

    public function testRegisterControllerOrClosure(): void
    {
        $router = new Router();
        $methodUri = 'GET:/';
        $dummyRunner = $this->createMock(Controller::class);

        $router->register($methodUri, $dummyRunner);

        $this->assertTrue($router->isRegistered($methodUri),'Controller or Clojure is not registered');
    }

    public function testResolveRouteAndExecuteRunner(): void
    {
        $router = new Router();
        $request = new Request('GET', '/');
        $request->method('GET');
        $request->uri('/');
        $methodUri = 'GET:/';
        $dummyRunner = $this->createMock(Controller::class);
        $dummyRunner
            ->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $router->register($methodUri, $dummyRunner);

        $this->assertNotNull($router->resolve($request),
            'runner should return a Request object');
    }

    public function testResolveAndExecuteClosure(): void
    {
        $router = new Router();
        $request = new Request('GET', '/');
        $request->method('GET');
        $request->uri('/');
        $methodUri = 'GET:/';

        $router->register($methodUri, fn() => new Response());

        $this->assertNotNull($router->resolve($request),
            'error calling the closure');
    }

    public function testResolveUnregisteredRoute(): void
    {
        $router = new Router();
        $request = new Request('POST', '/unknown');
        $request->method('POST');
        $request->uri('/unknown');

        $this->expectException(\InvalidArgumentException::class);
        $router->resolve($request);
    }

    /**
     * @dataProvider provideUriAndMaskData
     */
    public function testExtractParametersFromUri(...$params): void
    {
        $router = new Router();

        $paramList = [
            'responseUri' => $params[0],
            'routerMask' => $params[2],
            'expectedKey' => $params[3],
            'expectedValue' => $params[1]
        ];

        [$key, $value] = $router->extractParameters($paramList['responseUri'], $paramList['routerMask']);
        $this->assertEquals($paramList['expectedKey'], $key, '');
        $this->assertEquals($paramList['expectedValue'], $value, '');
    }

    /**
     * @return string[][]
     */
    public function provideUriAndMaskData(): array
    {
        return [
            'simple uri with value at the end' => [
                'GET:/sample/1', '1', 'GET:/sample/{id}', 'id'
            ],
            'simple uri with optional given value at the end' => [
                'GET:/sample/1', '1', 'GET:/sample/{?id}', 'id'
            ],
            'simple uri with optional value not given at the end' => [
                'GET:/sample/', '', 'GET:/sample/{?id}', 'id'
            ],
            'simple uri with value in the middle' => [
                'GET:/sample/3/sample', '3', 'GET:/sample/{product}/sample', 'product'
            ],
            'static file uri' => [
                'staticFile:/something.js', 'something.js', 'staticFile:/{file}', 'file'
            ],
        ];
    }

    public function testGetConcatenatedMethodUriFromRequest(): void
    {
        $router = new Router();
        $method = "GET";
        $uri = '/sample/1';

        $this->assertEquals($method.':'.$uri, $router->buildMethodUriString($method, $uri),
            'the generated method:uri is invalid');
    }

    public function testMatchRequestMethodUriWithMask(): void
    {
        $router = new Router();
        $methodUri =  'GET:/sample/1"';
        $mask = 'GET:/sample/{id}';
        $router->register($mask, fn() => true);

        $retrievedMask = $router->retrieveMask($methodUri);
        $this->assertEquals($mask, $retrievedMask, 'retrieved mask is invalid');
    }

    public function testMatchRequestMethodUriWithMaskFailException(): void
    {
        $router = new Router();
        $methodUri =  'GET:/sample/1/sample"';
        $mask = 'GET:/sample/{id}';
        $router->register($mask, fn() => true);

        $this->expectException(\InvalidArgumentException::class);
        $router->retrieveMask($methodUri);
    }

    /**
     * @dataProvider provideStaticFileUris
     */
    public function testUriIsAStaticFileRequest(string $uri): void
    {
        $router = new Router();
        $this->assertTrue($router->isStaticFileRequest($uri));
    }

    /**
     * @return string[][]
     */
    public function provideStaticFileUris(): array
    {
        return [
            'js uri' => ['/something.js'],
            'css uri' => ['/something.css'],
            'jpg uri' => ['/something.jpg'],
            'png uri' => ['/something.png'],
        ];
    }

    /**
     * @dataProvider provideStaticFileUris
     */
    public function testBuildMethodUriStringReturnsFileNameAsParameter(string $uri): void
    {
        $router = new Router();
        $this->assertEquals("staticFile:{$uri}",
            $router->buildMethodUriString('GET', $uri));
    }
}