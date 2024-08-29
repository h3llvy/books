<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Data Generation Successful';
?>

<div class="site-success">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Успешно!</h1>
        <p class="lead">Данные были успешно сгенерированы.</p>
        <?= Html::a('Домой', Yii::$app->homeUrl, ['class' => 'btn btn-primary']) ?>
    </div>
</div>
