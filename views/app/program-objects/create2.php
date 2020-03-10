<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */

$this->title = 'Создание объекта';
$this->params['breadcrumbs'][] = ['label' => 'Программа модернизации', 'url' => ['program/view']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form2', [
    'model' => $model,
]) ?>