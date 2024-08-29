<?php

namespace app\entities;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string $year
 * @property string $description
 * @property string $isbn
 * @property string $image
 *
 * @property AuthorBook[] $authorBooks
 * @property Author[] $authors
 */
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['title', 'year', 'description', 'isbn', 'image'], 'required'],
            [['description'], 'string'],
            [['title', 'year', 'image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
        ];
    }

    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('author_book', ['book_id' => 'id']);
    }

    public function getAuthorNames(): string
    {
        return implode(', ', $this->getAuthors()
            ->select(new Expression(Author::fullNameSql('text')))
            ->column());
    }
}
