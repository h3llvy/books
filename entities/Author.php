<?php

namespace app\entities;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property int|null $books_count
 *
 * @property AuthorBook[] $authorBooks
 * @property Book[] $books
 */
class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'authors';
    }

    public static function fullNameSql($nameField = null) : string
    {
        if (empty($nameField)) {
            return "CONCAT(first_name, ' ', middle_name, ' ', last_name)";
        }
        return "CONCAT(first_name, ' ', middle_name, ' ', last_name) as {$nameField}";
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name'], 'required'],
            [['books_count'], 'integer'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 255],
        ];
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['author_id' => 'id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('author_book', ['author_id' => 'id']);
    }

    public function getAuthorStat()
    {
        return $this->hasOne(AuthorStat::class, ['author_id' => 'id']);
    }
}
