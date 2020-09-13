<?php
?>


<table>
    <thead>
    <tr>
        <th>id орг</th>
        <th>субъект</th>
        <th>название орг</th>
        <th>общий лимит</th>
        <th>Статус ДЭП</th>
        <th>объем на АТЗ не более</th>
        <th>АТЗ по программе</th>
        <th>Согласованный объем АТЗ</th>
        <th>Инн</th>
        <th>Статус ДКУ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($export as $item): ?>
        <tr>
            <td><?= $item['id_org'] ?></td>
            <td><?= $item['region'] ?></td>
            <td><?= $item['org'] ?></td>
            <td><?= $item['sum'] ?></td>
            <td><?= $item['dep_status'] ?></td>
            <td><?= $item['atz_nb'] ?></td>
            <td><?= $item['atz'] ?></td>
            <td><?= $item['atz_bud_fin'] ?></td>
            <td><?= $item['inn'] ?></td>
            <td><?= $item['dku_status'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
