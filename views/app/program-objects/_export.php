<?php

use app\models\ProgramObjects;

/** @var $objs ProgramObjects[] */
?>


<table>
    <thead>
    <tr>
        <td colspan="9">Статистика по бюджетам от <?= date('r') ?></td>
    </tr>
    <tr>
        <th>№</th>
        <th>ID ораганизации</th>
        <th>Вуз</th>
        <th>ID объекта</th>
        <th>Наименование</th>
        <th>Назначение</th>
        <th>Субъект РФ</th>
        <th>Город</th>
        <th>Улица,дом</th>
        <th>Приоритет</th>
        <th>Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($objs as $i => $obj): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $obj->id_org ?></td>
            <td><?= $obj->org->name ?></td>
            <td><?= $obj->id ?></td>
            <td><?= $obj->name ?></td>
            <td><?= $obj->assignment ?></td>
            <td><?= $obj->region->region ?></td>
            <td><?= $obj->city->city ?></td>
            <td><?= $obj->address ?></td>
            <td><?= $obj->id_priority ?></td>
            <td><?= $obj->program->finance_volume ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>

</table>
