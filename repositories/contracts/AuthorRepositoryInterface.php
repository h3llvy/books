<?php

namespace app\repositories\contracts;


interface AuthorRepositoryInterface
{
    public function findOptionsByQuery(string $query): array;

    public function findAllId(): array;

    public function deleteAll(): void;

    public function addMany(array $keys, array $values): void;
}