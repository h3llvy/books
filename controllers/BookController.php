<?php

namespace app\controllers;

use app\actions\Book\BookCreateAction;
use app\actions\Book\BookDeleteAction;
use app\actions\Book\BookIndexAction;
use app\actions\Book\BookUpdateAction;
use app\actions\Book\BookViewAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BookController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'view'],
                            'roles' => ['?', '@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actions()
    {
        return [
            'index' => BookIndexAction::class,
            'view' => BookViewAction::class,
            'create' => BookCreateAction::class,
            'update' => BookUpdateAction::class,
            'delete' => BookDeleteAction::class,
        ];
    }
}
