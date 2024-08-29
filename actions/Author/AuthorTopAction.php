<?php

namespace app\actions\Author;

use app\repositories\contracts\AuthorStatRepositoryInterface;
use yii\base\Action;

class AuthorTopAction extends Action
{
    public function __construct(
        $id,
        $controller,
        $config,
        private AuthorStatRepositoryInterface $repository,
    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run()
    {
        $year = $this->controller->request->get('year', date('Y'));

        $authorStats = $this->repository->findTop10CountBooksByYear($year);

        $years = $this->repository->findAllYear();

        return $this->controller->render('top', [
            'models' => $authorStats,
            'year' => $year,
            'years' => $years,
        ]);
    }
}