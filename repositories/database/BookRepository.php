<?php

namespace app\repositories\database;

use app\entities\AuthorBook;
use app\entities\AuthorStat;
use app\entities\Book;
use app\repositories\contracts\BookRepositoryInterface;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BookRepository implements BookRepositoryInterface
{
    public function update(Book $book): Book
    {
        $book->save(false);
        return $book;
    }

    public function addWithAuthors(Book $book, array $authorIds): Book
    {
        return Yii::$app->db->transaction(static function () use ($book, $authorIds) {
            $book->save(false);

            Yii::$app->db->createCommand()->batchInsert(
                AuthorBook::tableName(),
                ['author_id', 'book_id'],
                array_map(static fn($authorId) => [$authorId, $book->id], $authorIds)
            )->execute();

            $stats = AuthorStat::find()
                ->select('author_id')
                ->where([
                    'author_id' => $authorIds,
                    'year' => $book->year
                ])
                ->column();

            $statsDiff = array_diff($authorIds, $stats);
            if (!empty($statsDiff)) {
                Yii::$app->db->createCommand()->batchInsert(
                    AuthorStat::tableName(),
                    ['year', 'author_id', 'books_count'],
                    array_map(static fn($authorId) => [$book->year, $authorId, 0], $statsDiff),
                )->execute();
            }

            AuthorStat::updateAllCounters(
                ['books_count' => 1],
                [
                    'author_id' => $authorIds,
                    'year' => $book->year
                ]
            );

            return $book;
        });
    }

    public function updateWithAuthors(Book $book, array $authorIds): Book
    {
        return Yii::$app->db->transaction(static function () use ($book, $authorIds) {
            $book->save(false);

            $book->unlinkAll('authorBooks', true);

            AuthorStat::updateAllCounters(
                ['books_count' => -1],
                [
                    'author_id' => ArrayHelper::getColumn($book->authors, 'id'),
                    'year' => $book->year
                ]
            );

            Yii::$app->db->createCommand()->batchInsert(
                AuthorBook::tableName(),
                ['author_id', 'book_id'],
                array_map(static fn($authorId) => [$authorId, $book->id], $authorIds)
            )->execute();

            $book->refresh();

            AuthorStat::updateAllCounters(
                ['books_count' => 1],
                [
                    'author_id' => $authorIds,
                    'year' => $book->year
                ]
            );

            return $book;
        });
    }

    public function findById(int $id): Book
    {
        return Book::findOne($id);
    }

    public function getActiveDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Book::find(),
        ]);
    }

    public function addMany(array $keys, array $values): void
    {
        Yii::$app->db->createCommand()->batchInsert(Book::tableName(), $keys, $values)->execute();
    }

    public function deleteAll(): void
    {
        Book::deleteAll();
        AuthorStat::updateAll(['books_count' => 0]);
    }

    public function findAllIdYear(): array
    {
        return Book::find()
            ->select('id, year')
            ->createCommand()
            ->queryAll();
    }

    public function delete(Book $book):void
    {
        $book->delete();
    }
}