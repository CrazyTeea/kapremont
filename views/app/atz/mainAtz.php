<?php

use yii\helpers\Html;

$this->title = 'Антитерророистическая защищенность объектов';
$this->params['breadcrumbs'][] = $this->title;
?>


<script>
    window._Organization = <?= json_encode($organization) ?>;
    window._Region = <?= json_encode($region) ?>;

</script>

<div class="program-objects-view">
    <div id="app"></div>
</div>
