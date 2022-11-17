<?php

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\View\Manager;

class SampleController implements Controller
{

    public function handle(Request $request)
    {
        return container(Manager::class)->handle('homeSample.simplephp.php');
    }
}