<?php

declare(strict_types=1);

namespace Framework\Contracts;

interface FileHandler
{
    public function fileExist(string $filename): bool;

    public function retrieveFile(string $filename): string;

    public function createFile(string $filename): string;
}