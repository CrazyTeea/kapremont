<?php
/***
 * @var $docList array
 */

use yii\bootstrap4\Html;
?>


    <table class="table-bordered table">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Файл</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($docList as $doc):?>

            <tr>
                <td><?=$doc->type->label?></td>
                <td><?=  Html::a($doc->file->name,"/program/object/download-doc/$model->id?id={$doc->file->id}")?></td>
            </tr>

        <?php endforeach;?>
        </tbody>
    </table>
    <a class="btn btn-danger" target="_blank" href="/program/object/zip/<?=$model->id?>">Скачать архивом</a>

