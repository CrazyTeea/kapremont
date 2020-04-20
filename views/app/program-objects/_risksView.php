<?php
?>

<table class="table-bordered table">
    <thead>
    <tr>
        <th>Виды рисков</th>
        <th>Отрицательные влияния</th>
        <th>Способы защиты</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model->risks as $item): ?>
    <tr>
        <td><?=$item->types?></td>
        <td><?=$item->poison?></td>
        <td><?=$item->protect?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
