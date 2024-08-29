<?php

namespace app\repositories\database;

use app\entities\AuthorBook;
use app\repositories\contracts\AuthorBookRepositoryInterface;
use Yii;

class AuthorBookRepository implements AuthorBookRepositoryInterface
{
    public function addMany(array $keys, array $values): void
    {
        Yii::$app->db->createCommand()->batchInsert(AuthorBook::tableName(), $keys, $values)->execute();
    }
}