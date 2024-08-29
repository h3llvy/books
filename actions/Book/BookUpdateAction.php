<?php

namespace app\actions\Book;

use app\forms\UpdateBookForm;
use app\repositories\contracts\BookRepositoryInterface;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BookUpdateAction extends Action
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

    public function run(int $id)
    {
        $book = $this->bookRepository->findById($id);
        if ($book === null) {
            throw new NotFoundHttpException();
        }

        $form = new UpdateBookForm();

        $authors = array_map(
            static fn($e) => ['id' => $e->id, 'text' => $e->fullName()],
            $book->authors
        );

        $authorsMap = ArrayHelper::map($authors, 'id', 'text');

        $form->setAttributes(array_merge($book->getAttributes(), [
            'originalAuthorsMap' => $authorsMap,
        ]));

        if ($this->controller->request->isPost && $form->load($this->controller->request->post())) {
            $form->update($book);

            return $this->controller->redirect(['view', 'id' => $book->id]);
        }

        $form->authorsIds = array_keys($authorsMap);

        return $this->controller->render('update', [
            'model' => $form,
        ]);
    }
}