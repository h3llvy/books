<?php

namespace app\forms;

use app\entities\Author;
use app\entities\Book;
use app\entities\User;
use app\repositories\contracts\BookRepositoryInterface;
use app\services\SendSmsService;
use voku\helper\ASCII;
use Yii;
use yii\base\Model;
use yii\db\Expression;

class CreateBookForm extends Model
{
    public function __construct(
        $config,
        private BookRepositoryInterface $repository,
        private SendSmsService $sms,
    )
    {
        parent::__construct($config);
    }

    public $title;
    public $year;
    public $description;
    public $isbn;
    public $image;
    public $authorsIds = [];

    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['description'], 'string'],
            [['year'], 'integer', 'max' => 9999],
            [['title', 'image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            ['authorsIds', 'safe'],
        ];
    }

    public function create(): Book
    {
        $book = $this->repository->addWithAuthors(
            new Book($this->getAttributes(null, ['authorsIds'])),
            $this->authorsIds
        );

        $this->sms->send(
            User::find()->select('phone')->column(),
            ASCII::to_transliterate(
                'Вышла новая книга с авторами '
                . implode(', ', $book->getAuthors()->select(new Expression(Author::fullNameSql()))->column()
                )
            ),
        );

        return $book;
    }
}
