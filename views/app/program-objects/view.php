<?php

use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $canChange boolean */

YiiAsset::register($this);
?>
<div class="program-objects-view">
    <script>
        window.canChange = <?= $canChange ?>;
        window.object_status = <?=$model->status?>;
    </script>

    <div id="app"></div>

</div>


