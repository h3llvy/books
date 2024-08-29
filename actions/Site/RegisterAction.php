<?php

namespace app\actions\Site;

use app\forms\RegisterForm;
use Yii;
use yii\base\Action;

class RegisterAction extends Action
{
    public function run(RegisterForm $model)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->controller->goBack();
        }

        return $this->controller->render('register', [
            'model' => $model,
        ]);
    }
}
