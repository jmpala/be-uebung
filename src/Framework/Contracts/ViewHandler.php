<?php

namespace Framework\Contracts;

interface ViewHandler
{
    public function canHandle(string $viewName);

    public function handle(string $viewName, array $data);
}