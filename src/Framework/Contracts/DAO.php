<?php

namespace Framework\Contracts;

interface DAO
{
    public static function getTable(): string;

    public static function selectById(int $id): array;

    public static function selectAll(): array;

    public static function insert(array $dao): int;

    public static function update(array $dao): void;

    public static function delete(array $dao): void;

    public static function deleteById(int $id): void;

    public static function isCreated(int $id): bool;
}