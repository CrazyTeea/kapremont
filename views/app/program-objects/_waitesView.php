<?php
    function findWaited($arr,$index){
        foreach ($arr as $item){
            if ($item->element == $index)
                return $item;
        }
        return null;
    }
?>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Цели и задачи</th>
        <th>Планируемый показатель</th>
        <th>Единица измерения</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Проведение капитального ремонта, общая площадь</td>
        <td><?=($item = getElement($model->waites,0))? $item->plan : '' ?></td>
        <td>кв.м</td>
    </tr>
    <tr>
        <td>Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь</td>
        <td><?=($item = getElement($model->waites,1))? $item->plan : '' ?></td>
        <td>кв.м</td>
    </tr>
    <tr>
        <td>Снижение затрат на эксплуатацию</td>
        <td><?=($item = getElement($model->waites,2))? $item->plan ? 'Да' : 'Нет' : '' ?></td>
        <td></td>
    </tr>
    <tr>
        <td>Повышение энергоэффективности</td>
        <td><?=($item = getElement($model->waites,3))? $item->plan ? 'Да' : 'Нет' : '' ?></td>
        <td></td>
    </tr>
    <tr>
        <td>Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия</td>
        <td><?=($item = getElement($model->waites,4))? $item->plan ? 'Да' : 'Нет' : '' ?></td>
        <td></td>
    </tr>

    <?php for ($i = 5 ; $i < count($model->waites); $i++):?>
        <tr>
            <td><?=$model->waites[$i]->aim?></td>
            <td><?=$model->waites[$i]->plan?></td>
            <td><?=$model->waites[$i]->changes?></td>
        </tr>
    <?php endfor;?>

    </tbody>
</table>

