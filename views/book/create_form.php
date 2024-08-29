<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\forms\CreateBookForm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'authorsIds')->widget(Select2::class, [
        'options' => [
            'placeholder' => 'Выберите авторов...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['author/search']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {
                return {
                    q: params.term
                };
            }'),
                'processResults' => new JsExpression('function(data) {
                return {
                    results: data.items
                };
            }'),
                'cache' => true
            ]
        ],
    ])->label('Авторы'); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
