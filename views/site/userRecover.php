<?php
/***
 * @var \app\models\forms\UserRecover $model
 */
?>

<div class="row">
    <div class="col-md-4">

        <?= \yii\bootstrap4\Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => 'Восстановление пароля ИАСМОН. Введите логин иасмон, затем нажмите кнопку, если все пройдет успешно, вас перенаправит на страницу авторизации',
        ])?>

        <?php $form = \yii\bootstrap4\ActiveForm::begin();?>

        <?= $form->field($model,'username')?>
        <?= \yii\bootstrap4\Html::submitButton('Восстановить аккаунт',['class'=>'btn btn-primary'])?>

        <?php \yii\bootstrap4\ActiveForm::end();?>
    </div>
</div>

