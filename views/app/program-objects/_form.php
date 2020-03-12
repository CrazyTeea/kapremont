<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-objects-form">

    <script>
        window.MODEL = {
            base:<?=\yii\helpers\Json::encode($model)?>,
            svedenia:<?=\yii\helpers\Json::encode($progObjectsEvents)?>,
            necessary:<?=\yii\helpers\Json::encode($proObjectsNecessary)?>,
            waited:<?=\yii\helpers\Json::encode($progObjectsWaites)?>,
            riscs:<?=\yii\helpers\Json::encode($progObjectsRiscs)?>,
        };
    </script>

</div>
