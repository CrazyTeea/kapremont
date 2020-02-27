<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DevelopmentProgramme */

$this->title = 'Create Development Programme';
$this->params['breadcrumbs'][] = ['label' => 'Development Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="development-programme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
