<?php

namespace app\actions\Site;

use app\forms\LoginForm;
use Yii;
use yii\base\Action;

class LoginAction extends Action
{
    public function run(LoginForm $model)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        }

        return $this->controller->render('login', [
            'model' => $model,
        ]);
    }
}
