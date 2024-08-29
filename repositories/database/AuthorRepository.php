<?php

namespace app\repositories\database;

use app\entities\Author;
use app\entities\AuthorBook;
use app\entities\AuthorStat;
use app\entities\Book;
use app\repositories\contracts\AuthorRepositoryInterface;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class AuthorRepository implements AuthorRepositoryInterface
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
                    ['year', 'author_id'],
                    array_map(static fn($authorId) => [$book->year, $authorId], $statsDiff),
                );
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

    public function findOptionsByQuery(string $query): array
    {
        return Author::find()
            ->select(new Expression(Author::fullNameSql('text') . ', id'))
            ->andFilterWhere(['like', Author::fullNameSql(), $query])
            ->asArray()
            ->all();
    }

    public function findAllId(): array
    {
        return Author::find()
            ->select('id')
            ->column();
    }

    public function deleteAll(): void
    {
        Author::deleteAll();
    }

    public function addMany(array $keys, array $values): void
    {
        Yii::$app->db->createCommand()->batchInsert(Author::tableName(), $keys, $values)->execute();
    }
}