<?php

namespace app\actions\Book;

use app\repositories\contracts\BookRepositoryInterface;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class BookViewAction extends Action
{
    public function __construct(
        $id,
        $controller,
        $config,
        private BookRepositoryInterface $bookRepository,

    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run($id)
    {
        $model = $this->bookRepository->findById($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $this->controller->render('view', [
            'model' => $model,
        ]);
    }
}
