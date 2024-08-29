<?php

namespace app\repositories\contracts;


interface AuthorBookRepositoryInterface
{
    public function addMany(array $keys, array $values): void;
}