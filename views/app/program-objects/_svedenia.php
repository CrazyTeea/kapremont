<?php
$arr=[
        'Проведение тендера и заключение договора на выполнение обследования',
    'Выполнение обследования, подготовка и утверждение дефектного акта',
    'Утверждение задания на проектирование',
    'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
    'Подготовка проектно-сметной документации',
    'Прохождение экспертизы проектно-сметной документации',
    'Проведение тендера и заключение договора на выполнение строительно-монтажных работ	',
    'Выполнение строительно-монтажных работ	',

]

?>
<div style="overflow: auto">
    <table class="table-bordered table">
        <thead>
        <tr>
            <th>Этап</th>
            <th>Необходимость выполнения</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Стоимость реализации (тыс.руб)</th>
            <th>Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)</th>
            <th>Софинансирование из внебюджетных источников (тыс.руб)</th>
        </tr>
        </thead>
        <tbody >

        <?php foreach($progObjectsEvents as $i=> $objectsEvent):?>
            <tr >
                <td><?=$form->field($objectsEvent,"[{$i}]step")->hiddenInput(['value'=>$i])->label(false) ?>
                    <?=$arr[$i]?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]is_nessesary")->dropDownList(['Нет','Да'])->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]date_event_start")->input('date')->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]date_event_end")->input('date')->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]cost_real")->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]sum_bud_fin")->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]fin_vnebud_ist")->label(false)?></td>
            </tr>
        <?php endforeach;?>


        </tbody>
    </table>
</div>