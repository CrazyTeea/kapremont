<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;


$weara = [
        'Менее 20%',
      'От 20% до 50%',
      'От 50% до 70%',
      'От 70% до 90%',
      'Более 90%'
];

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
            [                      // the owner name of the model
                'attribute' => 'wear',
                'value' => function($model) use ($weara){return $weara[$model->wear and  $model->wear < 5 ? : 0];},
            ],

/*            'regulation:ntext',
            'event_type:ntext',
            'finance_sum',
            'coFinancing',*/
            'note:ntext',
        ],
    ]) ?>

</div>
