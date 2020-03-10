<?php
$arr=[
    'Фундаменты	',
'Отмостка',
'Стены',
'Колонны',
'Перегородки',
'Крыша',
'Кровля',
'Перекрытия',
'Полы',
'Окна',
'Двери',
'Ворота',
'Лестницы',
'Крыльца',
'Балконы/Лоджии',
'Внутренняя отделка',
'Наружняя отделка',
    ' Система электроснабжения',
    'Система водоснабжения',
    'Система водоотведения',
    'Система газоснабжения',
    'Система кондиционирования воздуха',
    'Система вентиляции',
    'Система отопления',
    'Система диспетчеризации',
    'Радиофикация',
];
?>

<div style="overflow: auto">
    <table class="table-bordered table">
        <thead>
        <tr>
            <th>Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте	</th>
            <th>Наличие на объекте	</th>
            <th>Материал конструкции	</th>
            <th>Срок эксплуатации с момента строительства или предыдущего капитального ремонта	</th>
            <th>Требуется капитальный ремонт	</th>
            <th>Обоснование необходимости</th>
        </tr>
        </thead>
        <tbody >

        <?php foreach($proObjectsNecessary as $i=> $objectsEvent):?>
            <tr >
                <td>
                    <?=$arr[$i]?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]nalichie")->checkbox(['class'=>'form-control'])->label(false)?></td>
                <td><?= $i<17 ?  $form->field($objectsEvent,"[{$i}]material")->label(false) : $form->field($objectsEvent,"[{$i}]material")->hiddenInput()->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]srok_eks")->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]kap_remont")->checkbox(['class'=>'form-control'])->label(false)?></td>
                <td><?=$form->field($objectsEvent,"[{$i}]obosnovanie")->label(false)?></td>
            </tr>
        <?php endforeach;?>


        </tbody>
    </table>
</div>
