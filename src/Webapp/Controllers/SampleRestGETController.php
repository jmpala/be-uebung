<?php

declare(strict_types=1);

namespace Webapp\Controllers;

use Framework\Contracts\Controller;
use Framework\DAOs\DesksDAO;
use Framework\Http\Request;
use Framework\Http\Response;

class SampleRestGETController implements Controller
{
    private DesksDAO $desksDAO;
    private Response $response;

    public function __construct()
    {
        $this->desksDAO = container(DesksDAO::class);
        $this->response = container(Response::class);
    }

    public function handle(Request $request): Response
    {
        $this->response->statusCode(200);
        $this->response->addHeader('Content-Type', 'application/json');
        $this->response->content(json_encode($this->desksDAO->selectAll()));
        return $this->response;
    }
}