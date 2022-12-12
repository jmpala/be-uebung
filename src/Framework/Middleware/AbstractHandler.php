<?php

namespace Framework\Middleware;

use Framework\Contracts\RequestHandler;
use Framework\Http\Request;

abstract class AbstractHandler implements RequestHandler
{
    private RequestHandler $next;

    public function setNext(RequestHandler $handler): void
    {
        $this->next = $handler;
    }

    public function handle(Request $request): Request
    {
        $this->process($request);

        if (isset($this->next)) {
            return $this->next->handle($request);
        }
        return $request;
    }

     abstract protected function process(Request $request): Request;
}