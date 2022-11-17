<?php

namespace Framework;

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testAppExist(): void
    {
        $app = App::getInstance();
        self::assertNotNull($app);
    }

    public function testFrameworkDIConfigFileExist(): void
    {
        $file = __DIR__ . '/../../src/Framework/Config/DIInstancesConf.php';
        $data = require $file;
        self::assertFileExists($file);
        self::assertNotNull($data);
    }

    public function testDBConfigFileExist(): void
    {
        $file = __DIR__ . '/../../src/Framework/Config/DBConf.php';
        $data = require $file;
        self::assertFileExists($file);
        self::assertNotNull($data);
    }

    //  Bootstrap application:
    //      - read configs (default)
    //          - DI config & User DI config
    //          - DB config & User DB config
    //      - create DI Container (give configuration of instances)
    //      - create Request
    //      - send request to router
    //      - cast to string and send to http-client
}
