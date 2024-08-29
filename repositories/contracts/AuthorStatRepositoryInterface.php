<?php

namespace app\repositories\contracts;


interface AuthorStatRepositoryInterface
{

    public function findAllYear(): array;

    public function findTop10CountBooksByYear(int $year): array;

    public function deleteAll(): void;

    public function addMany(array $keys, array $values): void;
}