<?php

/***
 * @var \app\models\UserInfo[] $models
 */

?>

<script>
    window.users_info = <?=\yii\helpers\Json::encode($models)?>
</script>

<div id="app"></div>
