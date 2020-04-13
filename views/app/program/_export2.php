<?php

/** @var $objs Program[]  */
use app\models\Program;

$newArr = [];

/**
 * @param $arr
 * @param $status
 * @param bool $all
 * @return int
 */
function counter($arr,$atr, $status,$all = false){
    if (is_array($arr)){
        $co = 0;
        foreach ($arr as $item){
            if ($all){
                if ($item->$atr)
                    $co++;
            }else
            {
                if ($item->$atr==$status)
                    $co++;
            }

        }
        return $co;
    }
    return 0;
}
$s1c = $s4c =$s3c =$s2c = $depc = $dkuc = $dkurc = $kapc = $atzc = $allc = 0;
foreach ($objs as $item){
    $region = (isset($item->objects) and isset($item->objects[0])) ?  $item->objects[0]->region->region : '';
    $city = (isset($item->objects) and isset($item->objects[0])) ?  $item->objects[0]->city->city : '';

    $kap =$item->finance_volume;
    $atz =$item->finance_events;
    $all = counter($item->objects,'status',[],true);

    $status1=counter($item->objects,'status',1);
    $status4=counter($item->objects,'status',4);
    $status3=counter($item->objects,'status',3);
    $status2=counter($item->objects,'status',2);
    $dep=counter($item->objects,'dep_status','approved');
    $dku=counter($item->objects,'dku_status','approved');
    $dku_rejected=counter($item->objects,'dku_status','rejected');

    $kapc += $kap;
    $atzc += $atz;
    $allc += $all;

    $s1c += $status1*1;
    $s2c += $status2*1;
    $s3c += $status3*1;
    $s4c += $status4*1;
    $depc += $dep*1;
    $dkuc += $dku*1;
    $dkurc += $dku_rejected*1;

    $newArr[] = [
        'region'=>$region,
        'city'=>$city,
        'org'=>$item->org->name,
        'kap'=>$kap,
        'atz'=>$atz,
        'all'=>$all,
        'status1'=>$status1,
        'status4'=>$status4,
        'status3'=>$status3,
        'status2'=>$status2,
        'dep'=>$dep,
        'dku'=>$dku,
        'dku_rejected'=>$dku_rejected,
    ];
}



?>


<table>
    <thead>
    <tr>
        <td colspan="14" > Статистика по статусам от <?=date('r')?></td>
    </tr>
    <tr>
        <th>№</th>
        <th>Субъект РФ</th>
        <th>Город</th>
        <th>Вуз</th>
        <th>Лимиты кап. ремонт</th>
        <th>Лимиты АТЗ</th>
        <th>Кол-во объектов капитального ремонта, предусмотренный программой</th>
        <th>В обработке(ЭКСПЕРТ)</th>
        <th>Возвращено на доработку(ЭКСПЕРТ)</th>
        <th>Не рекомендуется к согласованию (ЭКСПЕРТ)</th>
        <th>Рекомендуется к согласованию (ЭКСПЕРТ)</th>
        <th>Рассмотрено ДЭП (Минобрнауки России)</th>
        <th>Согласовано ДКУ (Минобрнауки России)</th>
        <th>Резерв (Минобрнауки России)</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Итого</td>
        <td></td>
        <td></td>
        <td></td>
        <td><?=$kapc?></td>
        <td><?=$atzc?></td>
        <td><?=$allc?></td>
        <td><?=$s1c?></td>
        <td><?=$s4c?></td>
        <td><?=$s3c?></td>
        <td><?=$s2c?></td>
        <td><?=$depc?></td>
        <td><?=$dkuc?></td>
        <td><?=$dkurc?></td>
    </tr>
    <?php foreach ($newArr as $i => $obj):?>
            <tr>
                <td><?=$i+1?></td>
                <td><?=$obj['region']?></td>
                <td><?=$obj['city']?></td>
                <td><?=$obj['org']?></td>
                <td><?=$obj['kap']?></td>
                <td><?=$obj['atz']?></td>
                <td><?=$obj['all']?></td>
                <td><?=$obj['status1']?></td>
                <td><?=$obj['status4']?></td>
                <td><?=$obj['status3']?></td>
                <td><?=$obj['status2']?></td>
                <td><?=$obj['dep']?></td>
                <td><?=$obj['dku']?></td>
                <td><?=$obj['dku_rejected']?></td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
