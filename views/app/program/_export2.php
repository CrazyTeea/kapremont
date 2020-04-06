<?php

/** @var $objs ProgramObjects[]  */
use app\models\ProgramObjects;


/**
 * @param $arr
 * @param $status
 * @return int
 */
function counter($arr, $status){
    if (is_array($arr)){
        $co = 0;
        foreach ($arr as $item){
            if ($item->status == $status)
                $co++;
        }
        return $co;
    }
    return 0;
}

?>


<table>
    <thead>
    <tr>
        <th>№</th>
        <th>Субъект РФ</th>
        <th>Город</th>
        <th>Вуз</th>
        <th>Наименование</th>
        <th>Назначение</th>


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
