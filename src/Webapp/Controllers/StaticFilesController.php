<?php

declare(strict_types=1);

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;

/*
 * TODO: Implement the Framework\Contracts\FileHandler::class to abstract the file managment to local, s3, etc
 */
class StaticFilesController implements Controller
{

    public function handle(Request $request): Response
    {
        $res = new Response();

        header('Content-Type: application/javascript; charset=UTF-8');
        $path = __DIR__ . '/../../../resources/static/';
        $file = $request->getURIParam('file');
        $res->content(readfile("{$path}{$file}"));

        return $res;
    }
}