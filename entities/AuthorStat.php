<?php

namespace app\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author_stats".
 *
 * @property int $id
 * @property int $author_id
 * @property int $year
 * @property int $books_count
 *
 * @property Authors $author
 */
class AuthorStat extends ActiveRecord
{
    public static function tableName()
    {
        return 'author_stats';
    }

    public function rules()
    {
        return [
            [['author_id', 'year', 'books_count'], 'required'],
            [['author_id', 'year', 'books_count'], 'integer'],
            [['author_id'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'year' => 'Year',
            'books_count' => 'Books Count',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
