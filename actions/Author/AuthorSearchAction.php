<?php

namespace app\actions\Author;

use app\repositories\contracts\AuthorRepositoryInterface;
use yii\base\Action;
use yii\web\Response;

class AuthorSearchAction extends Action
{
    public function __construct(
        $id,
        $controller,
        $config,
        private AuthorRepositoryInterface $repository,
    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $q)
    {
        $this->controller->response->format = Response::FORMAT_JSON;

        $authors = $this->repository->findOptionsByQuery($q);

        return [
            'items' => $authors
        ];
    }
}