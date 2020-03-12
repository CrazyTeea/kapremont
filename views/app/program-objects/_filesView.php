<?php
/***
 * @var $docList array
 */

use yii\bootstrap4\Html;
?>

<ul>
    <?php foreach ($docList as $doc):?>

            <li>
                <?=  Html::a($doc->file->name,"/program/object/download-doc/$model->id?id={$doc->file->id}")?>
            </li>

    <?php endforeach;?>
</ul>
