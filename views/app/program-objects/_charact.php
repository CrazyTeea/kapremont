<?php

use kartik\select2\Select2; ?>
 <?=$form->field($model,'name')?>
    <?=$form->field($model,'id_region')->widget(Select2::classname(), [
    'data' => \yii\helpers\ArrayHelper::map(\app\models\Regions::find()->all(),'id','region'),
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
    <?=$form->field($model,'id_city')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Cities::find()->all(),'id','city'),
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <?=$form->field($model,'kad_number')?>
    <?=$form->field($model,'year')?>
    <?=$form->field($model,'exploit_year')?>
    <?=$form->field($model,'exist_pred_nadz_orgs')?>
    <?=$form->field($model,'wear')?>
    <?=$form->field($model,'osn_isp_zdan')?>
    <?=$form->field($model,'prav_oper_upr')?>
    <?=$form->field($model,'assignment')?>
    <?=$form->field($model,'prav_sob')?>
    <?=$form->field($model,'square')?>
    <?=$form->field($model,'isp_v_ust_dey')?>
    <?=$form->field($model,'n_isp_v_ust_dey')?>
    <?=$form->field($model,'square_ar')?>
    <?=$form->field($model,'note')?>
