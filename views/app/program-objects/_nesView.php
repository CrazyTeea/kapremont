<?php

use yii\helpers\ArrayHelper;

$nesLabel = [
    'Фундаменты',
    'Отмостка',
    'Стены ',
    'Колонны',
    'Перегородки',
    'Крыша (покрытия)',
    'Кровля',
    'Перекрытия',
    'Полы',
    'Окна',
    'Двери',
    'Ворота',
    'Лестницы',
    'Крыльца',
    'Балконы/лоджии',
    'Внутренняя отделка',
    'Наружная отделка',
    'Система электроснабжения',
    'Система водоснабжения',
    'Система водоотведения',
    'Система газоснабжения',
    'Система кондиционирования воздуха',
    'Система вентиляции',
    'Система отопления',
    'Система диспетчеризации',
    'Радиофикация',
    'Телевидение эфирное',
    'Система видеонаблюдения',
    'Система интернет и телефонии',
    'Система контроля управления доступом',
    'Пожарная сигнализация',
    'Охранная сигнализация',
    'Мусоропроводы',
    'Лифты',
];

function getElement($arr,$index){
    foreach ($arr as $item){
        if ($item->element == $index)
            return $item;
    }
    return null;
}

?>

<table class="table-bordered table" >
    <thead>
    <tr>
        <th>Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте</th>
        <th>Наличие на объекте</th>
        <th>Материал конструкции</th>
        <th>Срок эксплуатации с момента строительства или предыдущего капитального ремонта</th>
        <th>Требуется капитальный ремонт</th>
        <th>Обоснование необходимости</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0;$i< 17;$i++): ?>
        <?php $item = getElement($model->necessary,$i);?>
        <tr>
            <td><?=$nesLabel[$i]?></td>
            <td><?=($item) ? $item->nalichie ? 'Да' : '' : ''?> </td>
            <td><?=($item) ? $item->nalichie ? $item->material : '' : ''?></td>
            <td><?=($item) ? $item->nalichie ? $item->srok_eks : '' : ''?></td>
            <td><?=($item) ? ($item->nalichie and $item->kap_remont) ? 'Да' : 'Нет' : ''?></td>
            <td><?=($item) ? $item->nalichie ? $item->obosnovanie : '' : ''?></td>
        </tr>
        </tbody>
    <?php endfor;?>
</table>


<table class="table-bordered table" >
    <thead>
    <tr>
        <th>Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте</th>
        <th>Наличие на объекте</th>
        <th>Срок эксплуатации с момента строительства или предыдущего капитального ремонта</th>
        <th>Требуется капитальный ремонт</th>
        <th>Обоснование необходимости</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 17;$i< 34;$i++): ?>
    <?php $item = getElement($model->necessary,$i);?>
    <tr>
        <td><?=$nesLabel[$i]?></td>
        <td><?=($item) ? $item->nalichie ? 'Да' : '' : ''?> </td>
        <td><?=($item) ? $item->nalichie ? $item->srok_eks : '' : ''?></td>
        <td><?=($item) ? ($item->nalichie and $item->kap_remont) ? 'Да' : 'Нет' : ''?></td>
        <td><?=($item) ? $item->nalichie ? $item->obosnovanie : '' : ''?></td>
    </tr>
    </tbody>
    <?php endfor;?>
</table>
