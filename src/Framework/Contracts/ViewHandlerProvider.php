<?php

namespace Framework\Contracts;

use Framework\View\Manager;

interface ViewHandlerProvider
{
    public function provideViewHandlers(Manager $manager): void;
}