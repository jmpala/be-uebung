<?php

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\View\Manager;

class SampleController implements Controller
{
    public function handle(Request $request): Response
    {

        return container(Response::class)->content(
            container(Manager::class)
                ->handle(
                    'homeSample.simplephp.php', [
                    'name' => 'Juan'
                ]));
    }
}