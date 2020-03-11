<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Программа модернизации', 'url' => ['/program/view']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="program-objects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'org.name',
            'name:ntext',
            'assignment:ntext',
            'square',
            'year',
            'wear',
/*            'regulation:ntext',
            'event_type:ntext',
            'finance_sum',
            'coFinancing',*/
            'note:ntext',
        ],
    ]) ?>

</div>
