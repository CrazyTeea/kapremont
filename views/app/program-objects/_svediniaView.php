<?php
$sved = [
        'Проведение тендера и заключение договора на выполнение обследования',
    'Выполнение обследования, подготовка и утверждение дефектного акта',
    'Утверждение задания на проектирование',
    'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
    'Подготовка проектно-сметной документации',
    'Прохождение экспертизы проектно-сметной документации',
    'Проведение тендера и заключение договора на выполнение строительно-монтажных работ',
    'Выполнение строительно-монтажных работ'
]
?>


<table class="table table-bordered">
    <thead>
    <tr>
        <th>№</th>
        <th>Этап</th>
        <th>Необходимость выполнения</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Стоимость реализации (тыс.руб)</th>
        <th>Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)</th>
        <th>Софинансирование из внебюджетных источников (тыс.руб)</th>
    </tr>
    </thead>
    <tbody>
    <?php $c=0;$v=0;$b=0; foreach ($model->svedenia as $i=> $item): ?>
        <?php
        $c+=$item->cost_real;
        $v+=$item->sum_bud_fin;
        $b+=$item->fin_vnebud_ist;
        ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?=$sved[$i]?></td>
            <td><?= $item->is_nessesary ? 'Да' : 'Нет' ?></td>
            <td><?= Yii::$app->getFormatter()->asDate($item->date_event_start,'php:d M.Y')?></td>
            <td><?= Yii::$app->getFormatter()->asDate($item->date_event_end,'php:d M.Y')?></td>
            <td><?= $item->cost_real ?></td>
            <td><?= $item->sum_bud_fin ?></td>
            <td><?= $item->fin_vnebud_ist ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <th>Итого</th>
        <td></td>
        <td></td>
        <td></td>
        <td><?= number_format($c, 3, '.',' ') ?></td>
        <td><?= number_format($v, 3, '.',' ') ?></td>
        <td><?= number_format($b, 3, '.',' ') ?></td>
    </tr>


    </tbody>
</table>
