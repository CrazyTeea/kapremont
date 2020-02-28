<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-objects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_org') ?>

    <?= $form->field($model, 'id_priority') ?>

    <?= $form->field($model, 'id_program') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'assignment') ?>

    <?php // echo $form->field($model, 'square') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'wear') ?>

    <?php // echo $form->field($model, 'regulation') ?>

    <?php // echo $form->field($model, 'event_type') ?>

    <?php // echo $form->field($model, 'finance_sum') ?>

    <?php // echo $form->field($model, 'coFinancing') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'system_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
