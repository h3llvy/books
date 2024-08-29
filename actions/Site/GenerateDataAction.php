<?php

namespace app\actions\Site;

use app\services\GenerateDataService;
use yii\base\Action;

class GenerateDataAction extends Action
{
    public function __construct(
        $id,
        $controller,
        $config,
        private GenerateDataService $generateDataService
    )
    {
        parent::__construct($id, $controller, $config);
    }

    public function run()
    {
        ($this->generateDataService)();

        return $this->controller->render('generate-data');
    }
}