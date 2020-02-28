<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Program Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="program-objects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_org',
            'id_priority',
            'id_program',
            'name:ntext',
            'assignment:ntext',
            'square',
            'year',
            'wear',
            'regulation:ntext',
            'event_type:ntext',
            'finance_sum',
            'coFinancing',
            'note:ntext',
            'system_status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
