<?php

use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-objects-form">
    <?php $form = ActiveForm::begin()?>

    <?=\yii\bootstrap4\Accordion::widget(
            [
                    'items'=>
                        [
                                [
                                        'label'=>'Характеристика объекта',
                                    'content'=>$this->render('_charact',compact('form','model'))
                                ],
                            [
                                'label'=>'Сведения о планируемых мероприятиях',
                                'content'=>$this->render('_svedenia',compact('form','progObjectsEvents'))
                            ],
                            [
                                'label'=>'Обоснование необходимости (целесообразности) планируемых мероприятий',
                                'content'=>$this->render('_necessary',compact('form','proObjectsNecessary'))
                            ],
                        ]
    ])?>

    <?=Html::submitButton('Сохранить')?>
    <?php ActiveForm::end()?>

</div>
