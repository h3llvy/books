<?php

namespace app\actions\Book;

use app\forms\CreateBookForm;
use yii\base\Action;

class BookCreateAction extends Action
{
    public function __construct($id, $controller, $config, private CreateBookForm $form)
    {
        parent::__construct($id, $controller, $config);
    }

    public function run()
    {
        if ($this->controller->request->isPost) {
            if ($this->form->load($this->controller->request->post()) && $this->form->validate()) {
                $book = $this->form->create();
                return $this->controller->redirect(['view', 'id' => $book->id]);
            }
        }

        return $this->controller->render('create', [
            'model' => $this->form,
        ]);
    }
}