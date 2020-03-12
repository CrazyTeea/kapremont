<?php
$prior = [
    '1',
    '2',
    '3',
    'резерв'
];
$wear = [
        'Менее 20%',
    'От 20% до 50%',
    'От 50% до 70%',
    'От 70% до 90%',
    'Более 90%'
];

use app\models\Regions;
use yii\helpers\ArrayHelper; ?>


<div class="container" id="export">
    <div class="row">
        <div class="col-xs-6">
            <h3>ОДОБРЕНО</h3>

            <p>Учёным советом
            <p>ФГБОУ ВО «______»
            <p>Протокол от «___» 2020 г №_____

        </div>
        <div class="col-xs-6">
           <h3> УТВЕРЖДАЮ</h3>

            <p>Ректор
            <p>ФГБОУ ВО «______»

            <p>Дата утверждения: «___» 2020 г

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-6">
            <h3>ОДОБРЕНО</h3>

            <p>Председатель Совета обучающихся
            <p>ФГБОУ ВО «______»

        </div>
    </div>
    <br>
    <br>
    <br>
    <br><br><br><br>
    <div class="text-center">
        <h4>
            ПРОГРАММА
            МОДЕРНИЗАЦИИ ИНФРАСТРУКТУРЫ, ВКЛЮЧАЯ КАПИТАЛЬНЫЙ РЕМОНТ ОБЪЕКТОВ И ПРОВЕДЕНИЕ МЕРОПРИЯТИЙ
            ПО АНТИТЕРРОРИСТИЧЕСКОЙ ЗАЩИЩЕННОСТИ ОБЪЕКТОВ
            ФГБОУ ВО «<?=$org->full_name?>» В 2020 ГОДУ

        </h4>
    </div>
    <br><br><br>
    <br><br><br><br>
    <br><br><br><br>
    <div class="row">
        <div class="col-xs-6">
            <p>Объём бюджетных ассигнований,
            <p>предусмотренных на реализацию
            <p>программы, утверждён Протоколом
            <p>заседания Бюджетной комиссии
            <p>от «__» февраля 2020 г. №_____

        </div>
        <div class="col-xs-6"></div>
    </div>
    <br><br><br><br>
    <div class="row">
        <div style="float: left" align="center">
            <p> Раздел 1. Общие сведения	3
            <p>Раздел 2. Антитеррористическая защищённость объектов (территорий)	4
            <p>Раздел 3. Капитальный ремонт	5
            <p>  3.1 Объекты, требующие капитального ремонта	5
            <p>  3.2 Информация об объектах, требующих капитального ремонта	6
            <p>  3.2.1. Характеристика объекта	6
            <p> 3.2.2. Сведения о планируемых мероприятиях	8
            <p> 3.2.3. Обоснование необходимости (целесообразности) планируемых мероприятий	10
            <p> 3.2.4. Опись прилагаемых документов	12
            <p> 3.2.5. Ожидаемые результаты	13
            <p> 3.2.6. Прогнозируемые риски	13
        </div>
    </div>
    <br><br><br>
    <br><br><br><br>
    <br><br><br><br> <br><br><br>
    <br><br><br><br>
    <br><br><br><br> <br><br><br>
    <br><br><br><br>
    <br><br><br><br>
    <div class="text-center">
        <h3>Раздел 1. Общие сведения</h3>
    </div>
    <table class="table-bordered table">
        <thead>
        <tr>
            <th>
                №
            </th>
            <th>
                Показатель
            </th>
            <th>
                Значение
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Полное наименование организации</td>
            <td><?=$org->full_name?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Сокращенное наименование организации</td>
            <td><?=$org->short_name?></td>
        </tr>
        <tr>
            <td rowspan="4">3</td>
            <td>Общая численность обучающихся по программам среднего профессионального образования, бакалавриата, специалитета, магистратуры, аспирантуры, включая очную и заочную формы обучения, из них:</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_sr_count : ''?></td>
        </tr>
        <tr>
            <td>Численность обучающихся за счет средств федерального бюджета</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_fed_count : ''?></td>
        </tr>
        <tr>
            <td>Численность обучающихся по договору с полным возмещением затрат</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_dog_count : ''?></td>

        </tr>
        <tr>
            <td>Общая численность обучающихся иностранных граждан и лиц без гражданства</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_in_count : ''?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Численность профессорско-преподавательского состава</td>
            <td><?=$org->orgInfo ? $org->orgInfo->prof_count : ''?></td>
        </tr>
        <tr>
            <td rowspan="6">8</td>
            <td>Обучающиеся, из них:</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_all : ''?></td>
        </tr>
        <tr>
            <td>Среднего профессионального образования</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_sr_pr_count : ''?></td>
        </tr>
        <tr>
            <td>Бакалавриата</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_bak_count : ''?></td>
        </tr>
        <tr>
            <td>Специалитета</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_spec_count : ''?></td>
        </tr>
        <tr>
            <td>Магистратуры</td>
            <td><?=$org->orgInfo ? $org->orgInfo->st_mag_count : ''?></td>
        </tr>
        <tr>
            <td>Аспиранты</td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="4">6</td>
            <td>Работники, из них:</td>
            <td><?=$org->orgInfo ? $org->orgInfo->rab_count : ''?></td>
        </tr>
        <tr>
            <td>Научные сотрудники</td>
            <td><?=$org->orgInfo ? $org->orgInfo->nauch_rab : ''?></td>

        </tr>
        <tr>
            <td>Профессорско-преподавательский состав</td>
            <td><?=$org->orgInfo ? $org->orgInfo->prof_prep_count : ''?></td>

        </tr>
        <tr>
            <td>Иные категории работников</td>
            <td><?=$org->orgInfo ? $org->orgInfo->in_kat_rab : ''?></td>

        </tr>
        <tr>
            <td>7</td>
            <td>Численность инвалидов и лиц с ограниченными возможностями здоровья</td>
            <td><?=$org->orgInfo ? $org->orgInfo->invalid_count : ''?></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Общая площадь всех зданий и сооружений</td>
            <td></td>
        </tr>
        <tr>
            <td>9</td>
            <td>Общая площадь всех зданий и сооружений, требующих капитального ремонта (на основании акта обследования или предписаний надзорных органов)</td>
            <td></td>
        </tr>
        <tr>
            <td>10</td>
            <td>Общая площадь всех зданий и сооружений, находящихся в аварийном состоянии (на основании акта обследования или предписаний надзорных органов)</td>
            <td></td>
        </tr>
        <tr>
            <td>11</td>
            <td>Общая площадь всех зданий и сооружений, требующих мероприятий по АТЗ</td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <br><br><br><br> <br><br><br>
    <br><br><br><br>
    <br><br><br><br>
    <div class="text-center">
        <h3>
            Раздел 2. Антитеррористическая защищённость объектов (территорий)
        </h3>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>№</th>
                <th>Направление расходов</th>
                <th>Сумма бюджетного финансирования (руб.)</th>
                <th>Сумма внебюджетного финансирования (руб.)</th>
                <th>Общий объем финансирования (руб.)</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Система видеонаблюдения</td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? $atz[0]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? $atz[0]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? $atz[0]->cost_b*1 + $atz[0]->cost_v*1: ''?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Система оповещения и управления эвакуацией</td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? $atz[1]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? $atz[1]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? (int)$atz[1]->cost_b + (int)$atz[1]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Система освещения</td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? $atz[2]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? $atz[2]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? (int)$atz[2]->cost_b + (int)$atz[2]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Средства охранной сигнализации</td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? $atz[3]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? $atz[3]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? (int)$atz[3]->cost_b + (int)$atz[3]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Средства тревожной сигнализации</td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? $atz[4]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? $atz[4]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? (int)$atz[4]->cost_b + (int)$atz[4]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Средства пожарной сигнализации</td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? $atz[5]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? $atz[5]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? (int)$atz[5]->cost_b + (int)$atz[5]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Средства телефонной связи и радиосвязи</td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? $atz[6]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? $atz[6]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? (int)$atz[6]->cost_b + (int)$atz[6]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Ограждение (в т.ч. ворота, шлагбаумы)</td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? $atz[7]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? $atz[7]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? (int)$atz[7]->cost_b + (int)$atz[7]->cost_v : ''?></td>
        </tr>
        <tr>
            <td>9</td>
            <td>СКУД</td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? $atz[8]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? $atz[8]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? (int)$atz[8]->cost_b + (int)$atz[8]->cost_v : ''?></td>
        </tr>
        <tr>
            <td></td>
            <td>Итого:</td>
            <td>c</td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>

    <div class="text-center">
       <h3>Раздел 3. Капитальный ремонт</h3>
    </div>
    <div class="text-center">
        <h3>
            3.1 Объекты, требующие капитального ремонта
        </h3>
    </div>

    <div style="float: right">
        Таблица 3.1. Приоритетные объекты
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Приоритет
                (1,2,3)
            </th>
            <th>Субъект РФ</th>
            <th>Кадастровый номер объекта</th>
            <th>Наименование объекта, требующего капитального ремонта</th>
            <th>Назначение</th>
            <th>Адрес объекта</th>
            <th>Год постройки</th>
            <th>Износ здания (%)</th>
            <th>Предписание надзорных органов: МЧС, Роспотребнадзор и т. д. (при наличии)</th>
            <th>Вид планируемого мероприятия</th>
            <th>Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
            <th>Софинансирование из внебюджетных источников (тыс. руб.)</th>
            <th>Примечание</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pr_ob as $index=>$item):?>
        <tr>
            <td><?=++$index ?></td>
            <td><?=$prior[$item->id_priority ? : 0] ?></td>
            <td><?php $reg = Regions::findOne($item->id_region); echo $reg ? $reg->region : ' ' ?></td>
            <td><?=$item->kad_number ?></td>
            <td><?=$item->name ?></td>
            <td><?=$item->assignment ?></td>
            <td><?=$item->address ?></td>
            <td><?=$item->year ?></td>
            <td><?=$wear[$item->wear and $item->wear<5? : 0] ?></td>
            <td><?=$item->exist_pred_nadz_orgs ? $item->podrobnosti : '' ?></td>
            <td></td>
            <td><?=$item ->finance_sum?></td>
            <td><?=$item ->coFinancing?></td>
            <td><?=$item ->note?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div style="float: right">
        Таблица 3.2. Резерв
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Приоритет
                (1,2,3)
            </th>
            <th>Субъект РФ</th>
            <th>Кадастровый номер объекта</th>
            <th>Наименование объекта, требующего капитального ремонта</th>
            <th>Назначение</th>
            <th>Адрес объекта</th>
            <th>Год постройки</th>
            <th>Износ здания (%)</th>
            <th>Предписание надзорных органов: МЧС, Роспотребнадзор и т. д. (при наличии)</th>
            <th>Вид планируемого мероприятия</th>
            <th>Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
            <th>Софинансирование из внебюджетных источников (тыс. руб.)</th>
            <th>Примечание</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($r_ob as $index=>$item):?>
            <tr>
                <td><?=++$index ?></td>
                <td><?=$prior[$item->id_priority ? : 0] ?></td>
                <td><?php $reg = Regions::findOne($item->id_region); echo $reg ? $reg->region : ' ' ?></td>
                <td><?=$item->kad_number ?></td>
                <td><?=$item->name ?></td>
                <td><?=$item->assignment ?></td>
                <td><?=$item->address ?></td>
                <td><?=$item->year ?></td>
                <td><?=$wear[$item->wear and $item->wear<5? : 0] ?></td>
                <td><?=$item->exist_pred_nadz_orgs ? $item->podrobnosti : '' ?></td>
                <td></td>
                <td><?=$item ->finance_sum?></td>
                <td><?=$item ->coFinancing?></td>
                <td><?=$item ->note?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <?php foreach ($objects as $index=> $object):?>
        <div class="text-center">
            <p><h5>Объект № <?=++$index?></h5>
            <p><?=$object->name?></p>
            <p>Приоритет:<?=$prior[$object->id_priority ? : 0]?></p>
        </div>
    <table class="table table-bordered">
        <tr>
            <td width="10%">1</td>
            <td>
                <p>- Объекты с готовой проектно-сметной документацией (не старше 2-х лет) и положительным заключением государственной экспертизы;
                <p>- Объекты с выборочным капитальным ремонтом (не требуется прохождение государственной экспертизы) на момент подачи заявки готовы все необходимые документы;

            </td>
        </tr>
        <tr>
            <td width="10%">2</td>
            <td>
                <p>- Объекты с выборочным капитальным ремонтом, на момент подачи заявки готовы не все необходимые документы;
                <p>- Объекты с готовой проектно-сметной документацией, на момент подачи заявки не получено положительное заключение государственной экспертизы.

            </td>
        </tr>
        <tr>
            <td width="10%">3</td>
            <td>
                <p>- Иные объекты
            </td>
        </tr>
        <tr>
            <td width="10%">резерв</td>
            <td>
                <p> - Объекты, по которым объём финансирования проведения мероприятий, предусмотренных программой, превышает предусмотренные лимиты
            </td>
        </tr>
    </table>
    <?php endforeach;?>
</div>

<style>
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        border:0;
        padding:0;

    }
    .row {
        margin: 10px 0 0 0 !important;
        padding: 0 !important;
    }
    @media print {
        @page {
            size: auto;
        }
    }
</style>