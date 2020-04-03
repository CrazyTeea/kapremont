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
        <th>№</th>
        <th>Субъект РФ</th>
        <th>Город</th>
        <th>Вуз</th>
        <th>Лимиты кап. ремонт</th>
        <th>Лимиты АТЗ</th>
        <th>Статус Программы</th>
        <th>Рекомендовано к утверждению по приоритетным объектам кап. Ремонт</th>
        <th>Рекомендовано к утверждению по  резервным объектам кап. Ремонт</th>
        <th>ИТОГО рекомендовано к утверждению</th>
        <th>Отклонение от лимитов, с учетом утвержденного резерва</th>
    </tr>
    </thead>

    <tbody>
    <?php /** @var \app\models\ProgramObjects[] $objs */
        foreach ($objs as $i => $obj):?>
            <tr>
                <td><?=$i+1?></td>
                <td><?=(is_array($obj->objects2) and isset($obj->objects2[0])) ? $obj->objects2[0]->region->region : ''?></td>
                <td><?=(is_array($obj->objects2) and isset($obj->objects2[0])) ? $obj->objects2[0]->city->city : ''?></td>
                <td><?=$obj->org->name?></td>
                <td><?=$obj->finance_events?></td>
                <td><?=$obj->cost?></td>
                <td><?=$obj->p_status ? 'Отправлено' : 'Не отправлено'?></td>
                <td><?=$obj->objectsCountPr?></td>
                <td><?= $obj->objectsCountRe?></td>
                <td><?= $obj->objectsCount?></td>
                <td><?= $obj->finance_events - $obj->objectsCount?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
