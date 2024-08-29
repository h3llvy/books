<?php

namespace app\controllers;

use app\actions\Site\GenerateDataAction;
use app\actions\Site\LoginAction;
use app\actions\Site\LogoutAction;
use app\actions\Site\RegisterAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'generate-data' => GenerateDataAction::class,
            'login' => LoginAction::class,
            'register' => RegisterAction::class,
            'logout' => LogoutAction::class,
        ];
    }
}
