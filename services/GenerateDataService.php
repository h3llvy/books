<?php

namespace app\services;

use app\repositories\contracts\AuthorBookRepositoryInterface;
use app\repositories\contracts\AuthorRepositoryInterface;
use app\repositories\contracts\AuthorStatRepositoryInterface;
use app\repositories\contracts\BookRepositoryInterface;
use Faker\Factory;
use Yii;
use yii\helpers\ArrayHelper;

class GenerateDataService
{
    public function __construct(
        private AuthorRepositoryInterface     $authorRepository,
        private BookRepositoryInterface       $bookRepository,
        private AuthorStatRepositoryInterface $authorStatRepository,
        private AuthorBookRepositoryInterface $authorBookRepository,
    )
    {
    }

    public function __invoke()
    {
        $faker = Factory::create();

        $authors = [];
        $authorCount = 25;

        for ($i = 0; $i < $authorCount; $i++) {
            $authors[$i] = [
                $faker->firstName,
                $faker->lastName,
                $faker->domainName,
            ];
        }

        $books = [];
        $bookCount = rand(150, 300);

        for ($i = 0; $i < $bookCount; $i++) {
            $title = $faker->sentence;
            $year = $faker->dateTimeBetween('-5 years')->format('Y');
            $description = $faker->text;
            $isbn = $faker->isbn13;
            $image = $faker->imageUrl;

            $books[] = [$title, $year, $description, $isbn, $image];
        }


        $transaction = Yii::$app->db->beginTransaction();

        $this->bookRepository->deleteAll();
        $this->authorRepository->deleteAll();

        $this->authorRepository->addMany(['first_name', 'last_name', 'middle_name'], $authors);
        $this->bookRepository->addMany(['title', 'year', 'description', 'isbn', 'image'], $books);

        $authorsIds = $this->authorRepository->findAllId();

        $books = $this->bookRepository->findAllIdYear();

        $booksMap = ArrayHelper::index($books, 'id');
        $authorsBooks = [];
        $authorStatMap = [];

        foreach ($booksMap as $bookId => $book) {
            $usedAuthors = [];
            for ($i = 0; $i < rand(1, min($authorCount, 5)); $i++) {
                for (; ;) {
                    $authorId = $authorsIds[array_rand($authorsIds)];
                    if (!in_array($authorId, $usedAuthors)) {
                        break;
                    }
                }

                $usedAuthors[] = $authorId;

                $authorsBooks[] = [$authorId, $bookId];

                $statKey = "{$book['year']}$authorId";
                $authorStatMap[$statKey] = (@$authorStatMap[$statKey] ?: 0) + 1;
            }
        }

        $authorStats = [];
        foreach ($authorStatMap as $yearAuthorId => $booksCount) {
            $year = substr($yearAuthorId, 0, 4);
            $authorId = substr($yearAuthorId, 4);

            $authorStats[] = [$year, $authorId, $booksCount];
        }

        $this->authorBookRepository->addMany(['author_id', 'book_id'], $authorsBooks);
        $this->authorStatRepository->addMany(['year', 'author_id', 'books_count'], $authorStats);

        $transaction->commit();
    }
}