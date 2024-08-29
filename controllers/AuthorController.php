<?php

namespace app\controllers;

use app\actions\Author\AuthorSearchAction;
use app\actions\Author\AuthorTopAction;
use yii\web\Controller;

/**
 * BookController implements the CRUD actions for Book model.
 */
class AuthorController extends Controller
{
    public function actions()
    {
        return [
            'top' => AuthorTopAction::class,
            'search' => AuthorSearchAction::class,
        ];
    }
}
