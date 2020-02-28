<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-objects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_org')->textInput() ?>

    <?= $form->field($model, 'id_priority')->textInput() ?>

    <?= $form->field($model, 'id_program')->textInput() ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'assignment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'square')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'wear')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'regulation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'event_type')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'finance_sum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coFinancing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'system_status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
