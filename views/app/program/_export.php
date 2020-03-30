<?php

?>


<table>
    <thead>
    <tr>
        <th>№</th>
        <th>Субъект РФ</th>
        <th>Город</th>
        <th>Вуз</th>
        <th>Лимиты кап. ремонт</th>
        <th>Лимиты АТЗ</th>
        <th>Статус Программы</th>
        <th>Кол-во объектов</th>
    </tr>
    </thead>

    <tbody>
    <?php /** @var \app\models\ProgramObjects[] $objs */
        foreach ($objs as $i => $obj):?>
            <tr>
                <td><?=$i+1?></td>
                <td><?=(is_array($obj->objects) and isset($obj->objects[0])) ? $obj->objects[0]->region->region : ''?></td>
                <td><?=(is_array($obj->objects) and isset($obj->objects[0])) ? $obj->objects[0]->city->city : ''?></td>
                <td><?=$obj->org->name?></td>
                <td><?=$obj->finance_events?></td>
                <td><?=$obj->cost?></td>
                <td><?=$obj->p_status ? 'Отправлено' : 'Не отправлено'?></td>
                <td><?=$obj->objectsCount?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
