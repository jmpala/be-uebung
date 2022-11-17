<?php

namespace Framework\Providers;

use Framework\View\Handlers\SimplePhpViewHandler;
use Framework\View\Manager;

class ViewHandlersProvider implements \Framework\Contracts\ViewHandlerProvider
{

    public function provideViewHandlers(Manager $manager): void
    {
        $this->registerInstances();
        $this->registerHandlers($manager);
    }

    public function registerInstances(): void
    {
        container()->register(SimplePhpViewHandler::class, SimplePhpViewHandler::class);
    }

    private function registerHandlers(Manager $manager): void
    {
        $manager->registerHandler(SimplePhpViewHandler::class, container(SimplePhpViewHandler::class));
    }
}