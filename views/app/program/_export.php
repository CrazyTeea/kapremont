<?php

function counter($arr,$status){
    $c=0;
    if ($arr)
        foreach ($arr as $item){
            if ($item->status == $status)
                $c++;
        }
    return $c;
}

?>


<table>
    <thead>
    <tr>
        <th rowspan="2">№</th>
        <th rowspan="2">Субъект РФ</th>
        <th rowspan="2">Город</th>
        <th rowspan="2">Вуз</th>
        <th rowspan="2">Лимиты кап. ремонт</th>
        <th rowspan="2">Лимиты АТЗ</th>
        <th rowspan="2">Статус Программы</th>
        <th colspan="5">Кол-во объектов</th>
    </tr>
    <tr>
        <th>Всего</th>
        <th>В обработке</th>
        <th>Рекомендуется к согласованию</th>
        <th>Не рекомендуется к согласованию</th>
        <th>Возвращено на доработку</th>
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
                <td><?= counter($obj->objects,1)?></td>
                <td><?= counter($obj->objects,2)?></td>
                <td><?= counter($obj->objects,3)?></td>
                <td><?= counter($obj->objects,4)?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
