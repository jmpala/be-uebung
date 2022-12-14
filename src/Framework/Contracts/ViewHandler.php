<?php

namespace Framework\Contracts;

interface ViewHandler
{
    public function canHandle(string $viewName): bool;

    public function handle(string $viewName, array $data): string;
}