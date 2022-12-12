<?php

namespace Webapp\Controllers\Overview;

use Framework\Contracts\Controller;
use Framework\Http\Request;
use Framework\Http\Response;

class ShowOverviewPageController implements Controller
{

    public function handle(Request $request): Response
    {
        return handleView('overview/overview.simplephp.php');
    }
}