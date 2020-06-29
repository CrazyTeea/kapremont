<?php
$labels = [
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
        <th>id_obj</th>
        <th>Этап</th>
        <th>Дата начала (план.)</th>
        <th>Дата окончания (план.)</th>
        <th>Фактическая Стоимость реализации (тыс.руб.)</th>
        <th>Фактическая Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
        <th>Фактическое Софинансирование из внебюджетных источников (тыс. руб.)</th>
        <th>Отметка о завершении этапа</th>
        <th>Подтверждающие документы</th>
        <th>Комментарий (текстовое поле Заполняет ВУЗ)</th>
        <th>Отметка Эксперта МОН Принято / не принято</th>
        <th>Комментарий эксперта МОН )</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($objs as $obj):?>
        <?php
        $arr = array_merge(\yii\helpers\ArrayHelper::toArray($obj['svedenia']),\yii\helpers\ArrayHelper::toArray($obj['svedenia2']));
        usort($arr,function($a,$b){return $a['step']-$b['step'];});
        ?>
        <?php foreach ($arr as $item):?>
        <tr>
            <td><?=$item['id_object']?></td>

            <?php
                switch ($item['step']){
                    case 0.1:{$step_name='Внесение пользователем закупки на обследование объекта в план закупок';break;}
                    case 0.2:{$step_name='Объявление пользователем аукциона на обследование объекта';break;}
                    case 3.3:
                    case 6.3:
                    case 0.3:{$step_name='Определение подрядчика по результату аукциона';break;}
                    case 3.4:
                    case 6.4:
                    case 0.4:{$step_name='Заключение договора с подрядчиком';break;}
                    case 3.1:{$step_name='Внесение пользователем закупки на ПСД	';break;}
                    case 3.2:{$step_name='Объявление пользователем аукциона на ПСД';break;}
                    case 6.1:{$step_name='Внесение пользователем закупки на выполнение СМР в план закупок.';break;}
                    case 6.2:{$step_name='Объявление аукциона на СМР';break;}
                    default:{
                        $step_name = isset($item['step_name']) ? $item['step_name'] : $labels[$item['step']] ?? null;
                    }
                }

                ?>
            <td><?=  $step_name ? $item['step']+1 .' '.$step_name : ''?></td>
            <td><?=$item['date_event_start']?></td>
            <td><?=$item['date_event_end']?></td>
            <td><?=$item['cost_real']?></td>
            <td><?=$item['sum_bud_fin']?></td>
            <td><?=$item['fin_vnebud_ist']?></td>
            <td><?=$item['is_nessesary'] ? 'Да' : 'Нет'?></td>
            <td><?=$item['access_document'].' '.(\app\models\EventsFiles::find()->where(['id_event'=>$item['id']])->orWhere(['id_event2'=>$item['id']])->one()->file_name ?? '' )?></td>
            <td><?=$item['comment'] ?></td>
            <td><?=$item['doneExpert'] ? 'Да' : 'Нет'?></td>
            <td><?=$item['commentExpert']?></td>
        </tr>
        <?php endforeach;?>
    <?php endforeach;?>
    </tbody>
</table>
