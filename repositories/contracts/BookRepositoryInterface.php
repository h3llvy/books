<?php

namespace app\repositories\contracts;

use app\entities\Book;
use yii\data\ActiveDataProvider;

interface BookRepositoryInterface
{
    public function findById(int $id): Book;

    public function getActiveDataProvider(): ActiveDataProvider;

    public function addWithAuthors(Book $book, array $authorIds): Book;

    public function addMany(array $keys, array $values): void;

    public function updateWithAuthors(Book $book, array $authorIds): Book;

    public function update(Book $book): Book;

    public function deleteAll(): void;

    public function findAllIdYear(): array;

    public function delete(Book $book): void;
}