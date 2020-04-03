<?php

function counter($arr,$status,$type = [0,1]){
    $c=0;
    if ($arr)
        foreach ($arr as $item){
            if ($item->status == $status)
                if (is_array($type)){
                    if (in_array($item->type,$type))
                        $c++;
                }else{
                    if ($item->type == $type)
                        $c++;
                }

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
                <td><?=(is_array($obj->objects) and isset($obj->objects[0])) ? $obj->objects[0]->region->region : ''?></td>
                <td><?=(is_array($obj->objects) and isset($obj->objects[0])) ? $obj->objects[0]->city->city : ''?></td>
                <td><?=$obj->org->name?></td>
                <td><?=$obj->finance_events?></td>
                <td><?=$obj->cost?></td>
                <td><?= counter($obj->objects,2,0)?></td>
                <td><?= counter($obj->objects,2,1)?></td>
                <td><?= $o = counter($obj->objects,2)?></td>
                <td><?= $obj->finance_events - $o?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
