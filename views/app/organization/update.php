<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<?php $form = ActiveForm::begin();?>
<?= $form->field($model,'square_all')->input('number',['step'=>'0.001']) ?>
<?= $form->field($model,'square_all_kap')->input('number',['step'=>'0.001']) ?>
<?= $form->field($model,'square_all_av')->input('number',['step'=>'0.001']) ?>
<?= $form->field($model,'square_all_atz')->input('number',['step'=>'0.001']) ?>
<?= Html::submitButton('Сохранить',['class' => 'btn btn-success'])?>
<?php ActiveForm::end()?>

