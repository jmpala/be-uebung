<?php

namespace Framework\Middleware;

use Framework\Contracts\RequestHandler;
use Framework\Http\Request;

class Middleware
{
    private array $handlers = [];

    public function pipe(RequestHandler $handler): self
    {
        if ($this->getLastHandler()) {
            $this->getLastHandler()->setNext($handler);
        }
        $this->handlers[] = $handler;
        return $this;
    }

    public function getLastHandler(): ?RequestHandler
    {
        return $this->handlers[count($this->handlers) - 1] ?? null;
    }

    public function handlerCount(): int
    {
        return count($this->handlers);
    }

    public function run(Request $request): Request
    {
        if ($this->handlerCount() > 0) {
            return $this->handlers[0]->handle($request);
        }
        return $request;
    }

}