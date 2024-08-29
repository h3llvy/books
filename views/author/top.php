<?php

use app\entities\AuthorStat;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var AuthorStat[] $models */
/** @var string $year */
/** @var int[] $years */

$this->title = 'Топ 10 авторов по количеству книг за ' . Html::encode($year);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php foreach ($years as $e): ?>
        <a class="btn btn-primary" href="<?= Url::toRoute(['author/top', 'year' => $e]) ?>"><?= $e ?></a>
    <?php endforeach; ?>
    <h3 class="mt-4">Top 10 Authors</h3>
    <ul class="list-group">
        <?php foreach ($models as $i => $model): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= ($i + 1) . '. ' ?>

                    <?= Html::encode($model->author->first_name) ?>
                    <?= Html::encode($model->author->middle_name) ?>
                    <?= Html::encode($model->author->last_name) ?>
                    </span>
                <span class="badge bg-primary rounded-pill"><?= Html::encode($model->books_count) ?> books</span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
