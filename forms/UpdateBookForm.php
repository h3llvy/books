<?php

namespace app\forms;

use app\entities\Book;
use app\repositories\contracts\BookRepositoryInterface;
use Yii;
use yii\base\Model;

class UpdateBookForm extends Model
{
    public $id;
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $image;
    public $authorsIds = [];
    public $originalAuthorsMap = [];

    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['description'], 'string'],
            [['year'], 'integer', 'max' => 9999],
            [['title', 'image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['authorsIds', 'originalAuthorsMap'], 'safe'],
        ];
    }

    public function update(Book $book): Book
    {
        $repository = Yii::createObject(BookRepositoryInterface::class);

        $book->setAttributes(
            $this->getAttributes(null, ['authors', 'originalAuthors'])
        );

        if (array_keys($this->originalAuthorsMap) != $this->authorsIds) {
            $book = $repository->updateWithAuthors(
                $book,
                $this->authorsIds
            );
        }

        return $repository->update($book);
    }

}
