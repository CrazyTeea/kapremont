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


$html = '';
$i_c1 = $i_c2= $i_c3 = $i_c4= $i_c5= $i_c6 = 0;
foreach ($objs as $i => $obj){
    $k = $i+1;
    $c0 = counter($obj->objects,2,0);
    $c1 = counter($obj->objects,2,1);
    $c12 = counter($obj->objects,2);
    $o = $obj->finance_volume - $c12;
    $i_c1 += $obj->finance_volume;
    $i_c2 += $obj->finance_events;
    $i_c3 += $c0;
    $i_c4 += $c1;
    $i_c5 += $c12;
    $i_c6 += $o;
    $html.=" <tr>
        <td>$k</td>";
    if (is_array($obj->objects) and isset($obj->objects[0])){
        $html.="<td>{$obj->objects[0]->region->region}</td>
        <td> {$obj->objects[0]->city->city}</td>";
    }else{
        $html.='<td></td><td></td>';
    }

    $html.="<td>{$obj->org->name}</td>
        <td>$obj->finance_volume</td>
        <td>$obj->finance_events</td>
        <td>$c0</td>
        <td>$c1</td>
        <td>$c12</td>
        <td>$o</td>
    </tr>";
}


?>


<table>
    <thead>
    <tr>
        <td colspan="10" > Статистика по бюджетам (Организация) от <?=date('r')?></td>
    </tr>
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
    <tr>
        <td>Итого</td>
        <td></td>
        <td></td>
        <td></td>
        <td><?=$i_c1?></td>
        <td><?=$i_c2?></td>
        <td><?=$i_c3?></td>
        <td><?=$i_c4?></td>
        <td><?=$i_c5?></td>
        <td><?=$i_c5?></td>

    </tr>
        <?=$html?>
    </tbody>

</table>
