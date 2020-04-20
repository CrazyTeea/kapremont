<?php

$u_b_f = 0;

foreach ($model->svedenia as $item){
    if ($item->is_nessesary)
        $u_b_f+=floatval($item->cost_real);
}


?>

<table class="table-bordered table">
    <thead>
    <tr>
        <th>Показатель</th>
        <th>Значение</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td>Краткое описание планируемых работ по объекту</td>
        <td><?=$model->object_opis ?? 0?></td>
    </tr>
    <tr>
        <td>Утвержденное бюджетное финансирование работ по объекту</td>
        <td><?=$u_b_f?></td>
    </tr>
    <tr>
        <td>Сумма освоенных бюджетных средств</td>
        <td>0</td>
    </tr>
    <tr>
        <td>Экономия бюджетных средств по объекту</td>
        <td>0</td>
    </tr>
    </tbody>
</table>
