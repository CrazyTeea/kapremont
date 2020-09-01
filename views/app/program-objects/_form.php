<?php

use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-objects-form">

    <script>
        window.MODEL = {
            base: <?=Json::encode($model)?>,
            svedenia: <?=Json::encode($progObjectsEvents)?>,
            necessary: <?=Json::encode($proObjectsNecessary)?>,
            waited: <?=Json::encode($progObjectsWaites)?>,
            riscs: <?=Json::encode($progObjectsRiscs)?>,
        };
    </script>
    <div id="app"></div>
</div>
