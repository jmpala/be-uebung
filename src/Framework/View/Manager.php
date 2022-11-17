<?php

namespace Framework\View;

use Framework\Contracts\ViewHandlerProvider;

class Manager
{
    protected array $viewHandlers = [];

    public function registerHandler(string $handlerName, $handler): static
    {
        $this->viewHandlers[$handlerName] = $handler;
        return $this;
    }

    public function hasHandler(string $handlerName): bool
    {
        return isset($this->viewHandlers[$handlerName]);
    }

    public function handle(string $viewPath, array $data = []): string
    {
        foreach ($this->viewHandlers as $handler) {
            if ($handler->canHandle($viewPath)) {
                return $handler->handle($viewPath, $data);
            }
        }
    }

    public function getHandlersFromProvider(ViewHandlerProvider $provider): void
    {
        $provider->provideViewHandlers($this);
    }
}