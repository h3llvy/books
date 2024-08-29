<?php

namespace app\actions\Book;

use app\repositories\contracts\BookRepositoryInterface;
use yii\base\Action;

class BookIndexAction extends Action
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

    public function run()
    {
        return $this->controller->render('index', [
            'dataProvider' => $this->bookRepository->getActiveDataProvider(),
        ]);
    }
}