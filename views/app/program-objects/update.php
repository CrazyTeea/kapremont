<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */

$this->title = 'Редактирование объекта: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Программа модернизации', 'url' => ['/program/view']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="program-objects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model', 'progObjectsEvents', 'progObjectsWaites', 'progObjectsRiscs', 'proObjectsNecessary')) ?>

</div>
