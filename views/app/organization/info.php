<?php
$this->title = 'Подробнее';
$this->params['breadcrumbs'][] = ['label' => 'Программа модернизации', 'url' => ['program/view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    window.canChange = <?=\yii\helpers\Json::encode($canChange)?> ;
</script>
<div id="app"></div>
