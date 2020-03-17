<?php
$prior = [
    1=>'1',
    2=>'2',
    3=>'3',
    4=>'резерв'
];
$wear = [
    'Менее 20%',
    'От 20% до 50%',
    'От 50% до 70%',
    'От 70% до 90%',
    'Более 90%'
];
$prav = [
    'fast'=>'Оперативное управление',
    'others'=>'Другое',
];
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

function getEvent($arr,$i_o,$index,$attr){

    if (isset($arr[$i_o]) and isset($arr[$i_o][$index]))
        return $arr[$i_o][$index]->$attr;
    return '';
}

function getSum($arr,$i_o,$attr){

    $sum = 0;
    if (isset($arr[$i_o]))
    {
        foreach ($arr[$i_o] as $item){
            $sum += floatval(isset($item->$attr) ? $item->$attr : 0);
        }
    }
    return $sum;

}

use app\models\Regions;
use yii\helpers\ArrayHelper; ?>


<div class="container" id="export">
    <div class="row">
        <div class="col-xs-6">
            <h3>ОДОБРЕНО</h3>

            <p>Учёным советом
            <p>ФГБОУ ВО «<?=$org->name?>»
            <p>Протокол от «___» 2020 г №_____

        </div>
        <div class="col-xs-6">
            <h3> УТВЕРЖДАЮ</h3>

            <p>Ректор
            <p>ФГБОУ ВО «<?=$org->name?>»
            <p><?=$org->orgInfo ? $org->orgInfo->rector : ''?>
            <p>Дата утверждения: «___» 2020 г

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-6">
            <h3>ОДОБРЕНО</h3>

            <p>Председатель Совета обучающихся
            <p>ФГБОУ ВО «<?=$org->name?>»

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
            ФГБОУ ВО «<?=$org->name?>» В 2020 ГОДУ

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
            <p> Раздел 1. Общие сведения
            <p>Раздел 2. Антитеррористическая защищённость объектов (территорий)
            <p>Раздел 3. Капитальный ремонт
            <p> 3.1 Объекты, требующие капитального ремонта
            <p> 3.2 Информация об объектах, требующих капитального ремонта
            <p> 3.2.1. Характеристика объекта
            <p> 3.2.2. Сведения о планируемых мероприятиях
            <p> 3.2.3. Обоснование необходимости (целесообразности) планируемых мероприятий
            <p> 3.2.4. Опись прилагаемых документов
            <p> 3.2.5. Ожидаемые результаты
            <p> 3.2.6. Прогнозируемые риски
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
        <tr class="text-center">
            <th class="text-center">
                №
            </th>
            <th class="text-center">
                Показатель
            </th>
            <th class="text-center">
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
            <td><?=$sq['s_k']?></td>
        </tr>
        <tr>
            <td>9</td>
            <td>Общая площадь всех зданий и сооружений, требующих капитального ремонта (на основании акта обследования или предписаний надзорных органов)</td>
            <td><?=$sq['s_k_s']?></td>
        </tr>
        <tr>
            <td>10</td>
            <td>Общая площадь всех зданий и сооружений, находящихся в аварийном состоянии (на основании акта обследования или предписаний надзорных органов)</td>
            <td><?=$sq['s_av']?></td>
        </tr>
        <tr>
            <td>11</td>
            <td>Общая площадь всех зданий и сооружений, требующих мероприятий по АТЗ</td>
            <td><?=$sq['s_atz']?></td>
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
        <tr class="text-center">
            <th class="text-center">№</th>
            <th class="text-center">Направление расходов</th>
            <th class="text-center">Сумма бюджетного финансирования (руб.)</th>
            <th class="text-center">Сумма внебюджетного финансирования (руб.)</th>
            <th class="text-center">Общий объем финансирования (руб.)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Система видеонаблюдения</td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? $atz[0]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? $atz[0]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(0,$atz) ? floatval($atz[0]->cost_b) + floatval($atz[0]->cost_v): ''?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Система оповещения и управления эвакуацией</td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? $atz[1]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? $atz[1]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(1,$atz) ? floatval($atz[1]->cost_b) + floatval($atz[1]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Система освещения</td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? $atz[2]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? $atz[2]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(2,$atz) ? floatval($atz[2]->cost_b) + floatval($atz[2]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Средства охранной сигнализации</td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? $atz[3]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? $atz[3]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(3,$atz) ? floatval($atz[3]->cost_b) + floatval($atz[3]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Средства тревожной сигнализации</td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? $atz[4]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? $atz[4]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(4,$atz) ? floatval($atz[4]->cost_b) + floatval($atz[4]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Средства пожарной сигнализации</td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? $atz[5]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? $atz[5]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(5,$atz) ? floatval($atz[5]->cost_b) + floatval($atz[5]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Средства телефонной связи и радиосвязи</td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? $atz[6]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? $atz[6]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(6,$atz) ? floatval($atz[6]->cost_b) + floatval($atz[6]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Ограждение (в т.ч. ворота, шлагбаумы)</td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? $atz[7]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? $atz[7]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(7,$atz) ? floatval($atz[7]->cost_b) + floatval($atz[7]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td>9</td>
            <td>СКУД</td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? $atz[8]->cost_b : ''?></td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? $atz[8]->cost_v : ''?></td>
            <td><?=ArrayHelper::keyExists(8,$atz) ? floatval($atz[8]->cost_b) + floatval($atz[8]->cost_v) : ''?></td>
        </tr>
        <tr>
            <td></td>
            <td>Итого:</td>
            <td><?=$atzC['bC']?></td>
            <td><?=$atzC['vC']?></td>
            <td><?=$atzC['bvC']?></td>
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
        <tr class="text-center">
            <th class="text-center">№ п/п</th>
            <th class="text-center">Приоритет
                (1,2,3)
            </th>
            <th class="text-center">Субъект РФ</th>
            <th class="text-center">Кадастровый номер объекта</th>
            <th class="text-center">Наименование объекта, требующего капитального ремонта</th>
            <th class="text-center">Назначение</th>
            <th class="text-center">Адрес объекта</th>
            <th class="text-center">Год постройки</th>
            <th class="text-center">Износ здания (%)</th>
            <th class="text-center">Предписание надзорных органов: МЧС, Роспотребнадзор и т. д. (при наличии)</th>
            <th class="text-center">Вид планируемого мероприятия</th>
            <th class="text-center">Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
            <th class="text-center">Софинансирование из внебюджетных источников (тыс. руб.)</th>
            <th class="text-center">Примечание</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pr_ob as $index=>$item):?>
            <tr>
                <td><?=++$index ?></td>
                <td><?= (!$item->type) ? $prior[$item->id_priority ? : 1] : 'Резерв' ?></td>
                <td><?php $reg = Regions::findOne($item->id_region); echo $reg ? $reg->region : ' ' ?></td>
                <td><?=$item->kad_number ?></td>
                <td><?=$item->name ?></td>
                <td><?=$item->assignment ?></td>
                <td><?=$item->address ?></td>
                <td><?=$item->year ?></td>
                <td><?=$wear[(!is_null($item->wear) and $item->wear<5)? $item->wear : 0] ?></td>
                <td><?=$item->exist_pred_nadz_orgs ? $item->regulation : '' ?></td>
                <td></td>
                <td><?=$item->finance_sum?></td>
                <td><?=$item->coFinancing?></td>
                <td><?=$item->note?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div style="float: right">
        Таблица 3.2. Резерв
    </div>

    <table class="table table-bordered">
        <thead>
        <tr class="text-center">
            <th class="text-center">№ п/п</th>
            <th class="text-center">Приоритет
                (1,2,3)
            </th>
            <th class="text-center">Субъект РФ</th>
            <th class="text-center">Кадастровый номер объекта</th>
            <th class="text-center">Наименование объекта, требующего капитального ремонта</th>
            <th class="text-center">Назначение</th>
            <th class="text-center">Адрес объекта</th>
            <th class="text-center">Год постройки</th>
            <th class="text-center">Износ здания (%)</th>
            <th class="text-center">Предписание надзорных органов: МЧС, Роспотребнадзор и т. д. (при наличии)</th>
            <th class="text-center">Вид планируемого мероприятия</th>
            <th class="text-center">Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</th>
            <th class="text-center">Софинансирование из внебюджетных источников (тыс. руб.)</th>
            <th class="text-center">Примечание</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($r_ob as $index=>$item):?>
            <tr>
                <td><?=++$index ?></td>
                <td><?= (!$item->type) ? $prior[$item->id_priority ? : 1] : 'Резерв' ?></td>
                <td><?php $reg = Regions::findOne($item->id_region); echo $reg ? $reg->region : ' ' ?></td>
                <td><?=$item->kad_number ?></td>
                <td><?=$item->name ?></td>
                <td><?=$item->assignment ?></td>
                <td><?=$item->address ?></td>
                <td><?=$item->year ?></td>
                <td><?=$wear[(!is_null($item->wear) and $item->wear<5)? $item->wear : 0] ?></td>
                <td><?=$item->exist_pred_nadz_orgs ? $item->regulation : '' ?></td>
                <td></td>
                <td><?=$item ->finance_sum?></td>
                <td><?=$item ->coFinancing?></td>
                <td><?=$item ->note?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <?php foreach ($objects as $index=> $object):?>
    <?php $kek = $index+1 ?>
        <div class="text-center">
            <p><h5>Объект № <?=$kek?></h5>
            <p><?=$object->name?></p>
            <p>Приоритет:<?=$prior[$object->id_priority ? : 1]?></p>
        </div>
        <table class="table table-bordered">
            <tr>
                <td>1</td>
                <td>
                    <p>- Объекты с готовой проектно-сметной документацией (не старше 2-х лет) и положительным заключением государственной экспертизы;
                    <p>- Объекты с выборочным капитальным ремонтом (не требуется прохождение государственной экспертизы) на момент подачи заявки готовы все необходимые документы;

                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>
                    <p>- Объекты с выборочным капитальным ремонтом, на момент подачи заявки готовы не все необходимые документы;
                    <p>- Объекты с готовой проектно-сметной документацией, на момент подачи заявки не получено положительное заключение государственной экспертизы.

                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>
                    <p>- Иные объекты
                </td>
            </tr>
            <tr>
                <td>резерв</td>
                <td>
                    <p> - Объекты, по которым объём финансирования проведения мероприятий, предусмотренных программой, превышает предусмотренные лимиты
                </td>
            </tr>
        </table>
        <div class="text-center">
            3.2.1. Характеристика объекта
        </div>
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th class="text-center">№</th>
                <th class="text-center">Показатель</th>
                <th class="text-center">Значение</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Полный адрес объекта</td>
                <td><?=$object->address?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Субъект Российской Федерации </td>
                <td><?=$object->region ? $object->region->region : ''?></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Кадастровый номер</td>
                <td><?=$object->kad_number?></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Год постройки здания</td>
                <td><?=$object->year?></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Год ввода здания в эксплуатацию</td>
                <td><?=$object->exploit_year?></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Год проведения последнего капитального ремонта/реконструкции</td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Наличие предписаний надзорных органов </td>
                <td><?=$object->exist_pred_nadz_orgs ? $object->regulation : 'Нет'?></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Износ здания, %</td>
                <td><?=$wear[(!is_null($object->wear) and $object->wear<5)? $object->wear : 0]?></td>
            </tr>
            <tr>
                <td rowspan="4">9</td>
                <td>Основание для использования здания</td>
                <td><?=$object->osn_isp_zdan ?></td>
            </tr>
            <tr>
                <td>Назначение</td>
                <td><?=$object->assignment ?></td>

            </tr>
            <tr>
                <td>Право оперативного управления (регистрационная запись, номер)</td>
                <td><?=$object->prav_oper_upr ?></td>

            </tr>
            <tr>
                <td>Право собственности</td>
                <td><?= is_string($object->prav_sob) ? $prav[$object->prav_sob] : '' ?></td>
            </tr>
            <tr>
                <td >10</td>
                <td>Общая площадь здания – всего, кв.м.</td>
                <td><?=$object->square ?></td>
            </tr>
            <tr>
                <!--  <td>из нее площадь по целям использования:
                      административная

                  </td>
                  <td></td>

              </tr>
              <tr>
                  <td>учебно-лабораторных зданий </td>
                  <td></td>
              </tr>
              <tr>
                  <td>в том числе: учебная</td>
                  <td></td>
              </tr>
              <tr>
                  <td> из нее площадь спортивно-оздоровительных сооружений</td>
                  <td></td>
              </tr>
              <tr>
                  <td>в том числе крытых спортивных сооружений</td>
                  <td></td>
              </tr>
              <tr>
                  <td>учебно-вспомогательная</td>
                  <td></td>
              </tr>
              <tr>
                  <td>в том числе библиотечно-архивная</td>
                  <td></td>
              </tr>
              <tr>
                  <td>культурно-просветительская и музейная</td>
                  <td></td>
              </tr>
              <tr>
                  <td>предназначенная для лабораторных и научно-исследовательских подразделений</td>
                  <td></td>
              </tr>
              <tr>
                  <td>общежитий</td>
                  <td></td>
              </tr>
              <tr>
                  <td>в том числе жилая</td>
                  <td></td>
              </tr>
              <tr>
                  <td>из нее занятая обучающимися</td>
                  <td></td>
              </tr>
              <tr>
                  <td>гостиничных и жилых</td>
                  <td></td>
              </tr>
              <tr>
                  <td>подсобных</td>
                  <td></td>
              </tr>
              <tr>
                  <td>из нее площадь пунктов общественного питания</td>
                  <td></td>
              </tr>
              <tr>
                  <td>медицинских</td>
                  <td></td>
              </tr>
              <tr>
                  <td>бытовых</td>
                  <td></td>
              </tr>
              <tr>
                  <td>инфраструктурных</td>
                  <td></td>
              </tr>
              <tr>
                  <td>производственных и складских</td>
                  <td></td>
              </tr>
              <tr>
                  <td>защитных, в том числе гражданской обороны и ЧС</td>
                  <td></td>
              </tr>
              <tr>
                  <td>прочих зданий</td>
                  <td></td>
              </tr>-->
              <tr>
                <td>11</td>
                <td>Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м</td>
                <td><?=$object->square_kap ?></td>
            </tr>
           <!-- <tr>
                <td>из нее площадь по целям использования:
                    административная
                </td>
                <td></td>

            </tr>
            <tr>
                <td>учебно-лабораторных зданий </td>
                <td></td>
            </tr>
            <tr>
                <td>в том числе: учебная</td>
                <td></td>
            </tr>
            <tr>
                <td> из нее площадь спортивно-оздоровительных сооружений</td>
                <td></td>
            </tr>
            <tr>
                <td>в том числе крытых спортивных сооружений</td>
                <td></td>
            </tr>
            <tr>
                <td>учебно-вспомогательная</td>
                <td></td>
            </tr>
            <tr>
                <td>в том числе библиотечно-архивная</td>
                <td></td>
            </tr>
            <tr>
                <td>культурно-просветительская и музейная</td>
                <td></td>
            </tr>
            <tr>
                <td>предназначенная для лабораторных и научно-исследовательских подразделений</td>
                <td></td>
            </tr>
            <tr>
                <td>общежитий</td>
                <td></td>
            </tr>
            <tr>
                <td>в том числе жилая</td>
                <td></td>
            </tr>
            <tr>
                <td>из нее занятая обучающимися</td>
                <td></td>
            </tr>
            <tr>
                <td>гостиничных и жилых</td>
                <td></td>
            </tr>
            <tr>
                <td>подсобных</td>
                <td></td>
            </tr>
            <tr>
                <td>из нее площадь пунктов общественного питания</td>
                <td></td>
            </tr>
            <tr>
                <td>медицинских</td>
                <td></td>
            </tr>
            <tr>
                <td>бытовых</td>
                <td></td>
            </tr>
            <tr>
                <td>инфраструктурных</td>
                <td></td>
            </tr>
            <tr>
                <td>производственных и складских</td>
                <td></td>
            </tr>
            <tr>
                <td>защитных, в том числе гражданской обороны и ЧС</td>
                <td></td>
            </tr>
            <tr>
                <td>прочих зданий</td>
                <td></td>
            </tr>-->
            <tr>
                <td>12</td>
                <td>Используется в уставной деятельности, кв.м</td>
                <td><?=$object->isp_v_ust_dey ?></td>
            </tr>
            <tr>
                <td>13</td>
                <td>Не используется в уставной деятельности, кв.м.</td>
                <td><?=$object->n_isp_v_ust_dey ?></td>
            </tr>
            <tr>
                <td>14</td>
                <td>Предоставлено в аренду, кв.м.</td>
                <td><?=$object->square_ar ?></td>
            </tr>
            <tr>
                <td>15</td>
                <td>Примечание:</td>
                <td><?=$object->note ?></td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            3.2.2. Сведения о планируемых мероприятиях
        </div>
        <table class="table-bordered table">
            <thead>
            <tr class="text-center">
                <th class="text-center"></th>
                <th class="text-center">Этап</th>
                <th class="text-center">Необходимость выполнения (да/нет)</th>
                <th class="text-center">Дата начала (план.)</th>
                <th class="text-center">Дата окончания (план.)</th>
                <th class="text-center">Стоимость реализации
                    (тыс.руб.)
                </th>
                <th class="text-center">Сумма бюджетного финансирования на проведение капитального ремонта
                    (тыс. руб.)
                </th>
                <th class="text-center">Софинансирование из внебюджетных источников (тыс. руб.)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Проведение тендера и заключение договора на выполнение обследования</td>
                <td><?=getEvent($events,$index,0,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,0,'date_event_start')?></td>
                <td><?=getEvent($events,$index,0,'date_event_end')?></td>
                <td><?=getEvent($events,$index,0,'cost_real')?></td>
                <td><?=getEvent($events,$index,0,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,0,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Выполнение обследования, подготовка и утверждение дефектного акта (дефектной ведомости). </td>
                <td><?=getEvent($events,$index,1,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,1,'date_event_start')?></td>
                <td><?=getEvent($events,$index,1,'date_event_end')?></td>
                <td><?=getEvent($events,$index,1,'cost_real')?></td>
                <td><?=getEvent($events,$index,1,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,1,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Утверждение задания на проектирование (в зависимости от содержания работ, выполняемых при капитальном ремонте объектов капитального строительства).</td>
                <td><?=getEvent($events,$index,2,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,2,'date_event_start')?></td>
                <td><?=getEvent($events,$index,2,'date_event_end')?></td>
                <td><?=getEvent($events,$index,2,'cost_real')?></td>
                <td><?=getEvent($events,$index,2,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,2,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Проведение тендера и заключение договора на подготовку проектно-сметной документации.</td>
                <td><?=getEvent($events,$index,3,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,3,'date_event_start')?></td>
                <td><?=getEvent($events,$index,3,'date_event_end')?></td>
                <td><?=getEvent($events,$index,3,'cost_real')?></td>
                <td><?=getEvent($events,$index,3,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,3,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Подготовка проектно-сметной документации.</td>
                <td><?=getEvent($events,$index,4,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,4,'date_event_start')?></td>
                <td><?=getEvent($events,$index,4,'date_event_end')?></td>
                <td><?=getEvent($events,$index,4,'cost_real')?></td>
                <td><?=getEvent($events,$index,4,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,4,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Прохождение экспертизы проектно-сметной документации.</td>
                <td><?=getEvent($events,$index,5,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,5,'date_event_start')?></td>
                <td><?=getEvent($events,$index,5,'date_event_end')?></td>
                <td><?=getEvent($events,$index,5,'cost_real')?></td>
                <td><?=getEvent($events,$index,5,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,5,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Проведение тендера и заключение договора на выполнение строительно-монтажных работ.</td>
                <td><?=getEvent($events,$index,6,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,6,'date_event_start')?></td>
                <td><?=getEvent($events,$index,6,'date_event_end')?></td>
                <td><?=getEvent($events,$index,6,'cost_real')?></td>
                <td><?=getEvent($events,$index,6,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,6,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Выполнение строительно-монтажных работ.</td>
                <td><?=getEvent($events,$index,7,'is_nessesary') ? 'Да' : 'Нет'?></td>
                <td><?=getEvent($events,$index,7,'date_event_start')?></td>
                <td><?=getEvent($events,$index,7,'date_event_end')?></td>
                <td><?=getEvent($events,$index,7,'cost_real')?></td>
                <td><?=getEvent($events,$index,7,'sum_bud_fin')?></td>
                <td><?=getEvent($events,$index,7,'fin_vnebud_ist')?></td>
            </tr>
            <tr>
                <td>9</td>
                <td>ИТОГО</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?=getSum($events,$index,'cost_real')?></td>
                <td><?=getSum($events,$index,'sum_bud_fin')?></td>
                <td><?=getSum($events,$index,'fin_vnebud_ist')?></td>
            </tr>
            </tbody>
        </table>

        <div class="text-center">
            3.2.3. Обоснование необходимости (целесообразности) планируемых мероприятий
        </div>

        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th class="text-center">№</th>
                <th class="text-center">Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте</th>
                <th class="text-center">Наличие на объекте (да/нет)</th>
                <th class="text-center">Материал конструкции</th>
                <th class="text-center">Срок эксплуатации с момента строительства или предыдущего капитального ремонта (реконструкции)</th>
                <th class="text-center">Требуется капитальный ремонт (да/нет)</th>
                <th class="text-center">Обоснование необходимости</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0,$k=1;$i<17;$i++,$k++): ?>
                <tr>
                    <td><?=$k?></td>
                    <td><?=$nesLabel[$i]?></td>
                    <td><?=getEvent($nes,$index,$i,'nalichie') ? 'Да' : 'Нет'?></td>
                    <td><?=getEvent($nes,$index,$i,'material')?></td>
                    <td><?=getEvent($nes,$index,$i,'srok_eks')?></td>
                    <td><?=getEvent($nes,$index,$i,'kap_remont') ? 'Да' : 'Нет'?></td>
                    <td><?=getEvent($nes,$index,$i,'obosnovanie')?></td>
                </tr>
            <?php endfor;?>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th class="text-center">№</th>
                <th class="text-center">Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте</th>
                <th class="text-center">Наличие на объекте (да/нет)</th>
                <th class="text-center">Срок эксплуатации с момента строительства или предыдущего капитального ремонта (реконструкции)</th>
                <th class="text-center">Требуется капитальный ремонт (да/нет)</th>
                <th class="text-center">Обоснование необходимости</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=17,$k=1;$i<34;$i++,$k++): ?>
                <tr>
                    <td><?=$k?></td>
                    <td><?=$nesLabel[$i]?></td>
                    <td><?=getEvent($nes,$index,$i,'nalichie') ? 'Да' : 'Нет'?></td>
                    <td><?=getEvent($nes,$index,$i,'srok_eks')?></td>
                    <td><?=getEvent($nes,$index,$i,'kap_remont') ? 'Да' : 'Нет'?></td>
                    <td><?=getEvent($nes,$index,$i,'obosnovanie')?></td>
                </tr>
            <?php endfor;?>
            </tbody>
        </table>
    <div class="text-center">
        3.2.4. Опись прилагаемых документов
    </div>

    <table class="table table-bordered">
        <thead>
        <tr class="text-center">
            <th class="text-center">№</th>
            <th class="text-center">Документ</th>
            <th class="text-center">Кол-во страниц</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Инвентарные карточки учета основных средств на объект недвижимого имущества и на земельный участок под указанным объектом;</td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Выписка из реестра федерального имущества на объект федерального имущества и на земельный участок под указанным объектом;</td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Правоустанавливающие и (или) правоудостоверяющие документы на объект недвижимого имущества и на земельный участок под указанным объектом;</td>
            <td></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Документы технического и кадастрового учета на объект недвижимого имущества;</td>
            <td></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Ситуационный план с указанием границ земельного участка, объекта недвижимого имущества и иных объектов (включая незавершенные строительные объекты), принадлежащих третьим лицам, расположенных на указанном земельном участке;</td>
            <td></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Акт технического осмотра объекта капитального строительства (документ, содержащий сведения о результатах обследования объекта капитального строительства, техническом состоянии строительных конструкций и инженерного оборудования такого объекта и количественной оценке фактических показателей качества строительных конструкций и инженерного оборудования по состоянию на дату обследования, для определения состава, объёмов и сроков работ по капитальному ремонту объекта капитального строительства); </td>
            <td></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Дефектная ведомость (первичный учётный документ, подготовленный в соответствии с требованиями законодательства Российской Федерации о бухгалтерском учёте по результатам обследования технического состояния объекта капитального строительства и содержащий перечень дефектов строительных конструкций и инженерного оборудования объекта капитального строительства с указанием качественных и количественных характеристик таких дефектов);</td>
            <td></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Фотографии объекта, предполагаемого к проведению капитального ремонта (подписанные по 2 шт. на листе А4, но не более 10 шт. на объект недвижимости);</td>
            <td></td>
        </tr>
        <tr>
            <td>9</td>
            <td>Предписания надзорных органов (при наличии);</td>
            <td></td>
        </tr>
        <tr>
            <td>10</td>
            <td>Задание на проектирование (корректировку проектной документации), составленное в соответствии с рекомендациями Минстроя РФ (в случае разработки/корректировки проектной документации и/или направления данной документации на экспертизу).</td>
            <td></td>
        </tr>
        <tr>
            <td>11</td>
            <td>Иные документы</td>
            <td></td>
        </tr>
        </tbody>
    </table>

    <div class="text-center">
        3.2.5. Ожидаемые результаты
    </div>

    <table class="table table-bordered">
        <thead>
        <tr class="text-center">
            <th class="text-center">№</th>
            <th class="text-center">Цели и задачи</th>
            <th class="text-center">Планируемый показатель</th>
            <th class="text-center">Ед. измерения</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Проведение капитального ремонта, общая площадь  </td>
            <td><?=getEvent($wai,$index,0,'plan')?></td>
            <td>кв.м</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь</td>
            <td><?=getEvent($wai,$index,1,'plan')?></td>
            <td>кв.м</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Снижение затрат на эксплуатацию</td>
            <td><?=getEvent($wai,$index,2,'plan')?></td>
            <td>да / нет </td>
        </tr>
        <tr>
            <td>4</td>
            <td>Повышение энергоэффективности</td>
            <td><?=getEvent($wai,$index,3,'plan')?></td>
            <td>да / нет </td>
        </tr>
        <tr>
            <td>5</td>
            <td>Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия </td>
            <td><?=getEvent($wai,$index,4,'plan')?></td>
            <td>да / нет </td>
        </tr>
        <?php if (ArrayHelper::keyExists($index,$wai)): ?>
            <?php for ( $i=5,$k=6;$i< count($wai[$index]); $i++,$k++): ?>
            <tr>
                <td><?=$k?></td>
                <td><?=getEvent($wai,$index,$i,'aim')?></td>
                <td><?=getEvent($wai,$index,$i,'plan')?></td>
                <td><?=getEvent($wai,$index,$i,'changes')?></td>
            </tr>
            <?php endfor;?>
        <?php endif;?>

        </tbody>
    </table>

    <table class="table table-bordered">
        <thead class="table-bordered table">
            <tr>
                <th class="text-center">№</th>
                <th class="text-center">Виды рисков</th>
                <th class="text-center">Отрицательное влияние</th>
                <th class="text-center">Способы защиты</th>
            </tr>
        </thead>
        <tbody>
        <?php if (ArrayHelper::keyExists($index,$risks)): ?>
            <?php foreach ($risks[$index] as $k =>$risk):?>
                <tr>
                    <td><?=++$k?></td>
                    <td><?=getEvent($risks,$index,$k,'types')?></td>
                    <td><?=getEvent($risks,$index,$k,'poison')?></td>
                    <td><?=getEvent($risks,$index,$k,'protect')?></td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>

    <?php endforeach;?>
</div>

<style>
    body{
        font-family: "Times New Roman", serif;
    }
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        border:0;
        padding:0;


    th td{
        text-align: center !important;
        vertical-align: middle !important;
    };

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