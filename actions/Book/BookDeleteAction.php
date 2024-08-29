<?php

namespace app\actions\Book;

use app\repositories\contracts\BookRepositoryInterface;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class BookDeleteAction extends Action
{
    public function __construct(
        $id,
        $controller,
        $config,
        private BookRepositoryInterface $bookRepository
    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run($id)
    {
        $book = $this->bookRepository->findById($id);
        if (!$book) {
            throw new NotFoundHttpException();
        }

        $this->bookRepository->delete($book);

        return $this->controller->redirect(['index']);
    }
}