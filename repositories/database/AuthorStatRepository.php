<?php

namespace app\repositories\database;

use app\entities\AuthorStat;
use app\repositories\contracts\AuthorStatRepositoryInterface;
use Yii;

class AuthorStatRepository implements AuthorStatRepositoryInterface
{
    public function deleteAll(): void
    {
        AuthorStat::deleteAll();
    }


    public function findAllYear(): array
    {
        return AuthorStat::find()
            ->select('year')
            ->groupBy('year')
            ->column();
    }

    public function findTop10CountBooksByYear(int $year): array
    {
        return AuthorStat::find()
            ->with('author')
            ->where(['year' => $year])
            ->orderBy('books_count DESC')
            ->limit(10)
            ->all();
    }

    public function addMany(array $keys, array $values): void
    {
        Yii::$app->db->createCommand()->batchInsert(AuthorStat::tableName(), $keys, $values)->execute();
    }
}