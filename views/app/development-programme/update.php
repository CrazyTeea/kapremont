<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DevelopmentProgramme */

$this->title = 'Update Development Programme: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Development Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="development-programme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
