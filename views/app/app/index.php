<div>
говно жопа
</div>
<?php

use app\models\ProgramObjects;

// $model = ProgramObjects::find()-> where(['id' => 115, 'system_status' => 1])->all();
// var_dump($model);

?>
<?php foreach($model as $program): ?>
    <?= $program->dep_status ?>
<?php endforeach; ?>