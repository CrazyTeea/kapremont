<?php
use app\models\ProgramObjects;
/** @var $objs ProgramObjects[]  */
?>


<table>
    <thead>
    <tr>
        <th>№</th>
        <th>Вуз</th>
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
    <?php foreach ($objs as $i => $obj):?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$obj->org->name?></td>
            <td><?=$obj->name?></td>
            <td><?=$obj->assignment?></td>
            <td><?=$obj->region->region?></td>
            <td><?=$obj->city->city?></td>
            <td><?=$obj->address?></td>
            <td><?=$obj->id_priority?></td>
            <td><?=$obj->program->finance_volume?></td>
        </tr>
    <?php endforeach;?>
    </tbody>

</table>
