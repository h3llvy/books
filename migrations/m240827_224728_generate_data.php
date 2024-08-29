<?php

use app\actions\Site\GenerateDataAction;
use app\repositories\contracts\AuthorRepositoryInterface;
use app\repositories\contracts\BookRepositoryInterface;
use app\services\GenerateDataService;
use yii\db\Migration;

/**
 * Class m240827_224728_generate_data
 */
class m240827_224728_generate_data extends Migration
{
    public function safeUp()
    {
        $service = Yii::createObject(GenerateDataService::class);
        $service();
    }

    public function safeDown()
    {
        Yii::createObject(BookRepositoryInterface::class)
            ->deleteAll();

        Yii::createObject(AuthorRepositoryInterface::class)
            ->deleteAll();
    }
}
