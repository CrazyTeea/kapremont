<?php


namespace app\controllers\rest;


use app\models\Organizations;
use app\models\Program;
use app\models\User;
use Yii;
use yii\helpers\Json;

class SystemController extends RestController
{
    public function actionGetPage(){
        if ($data = Yii::$app->getRequest()->getQueryParams()){
            $data = (object)$data;
            switch ($data->pageName){
                case 'main':{
                    $ret['fields']=[
                        ['key'=>'id','label'=>'#'],
                        ['key'=>'label','label'=>'Показатель'],
                        ['key'=>'value','label'=>'Значение']
                    ];
                    $program = Program::findOne(['id_org'=>$data->id_org]);
                    if (!$program)
                        return null;
                    $ret['items'] = [
                        ['id' => 1, 'label' =>
                            "Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов,тыс. рублей",
                            'value' => round( $program->finance_volume,2)
                        ],
                        ['id' => 2, 'label' =>
                            "Из них на реализацию мероприятий по антитеррористической защищенности, не более,тыс. рублей",
                            'value' => round( $program->finance_events,2)
                        ],
                        ['id' => 3, 'label' =>
                            "Предельная стоимость капитального ремонта 1 кв. м. площади, рублей",
                            'value' => round( $program->cost,2)
                        ],
                        ['id' => 4, 'label' =>
                            "Ожидаемая площадь капитального ремонта, кв.м.",
                            'value'=>  round( ($program->finance_volume*1000 - $program->finance_events*1000)/$program->cost,2)
                        ],
                    ];
                    return $ret;
                    break;
                }
                case 'programView':{
                    $ret['objects']['fields']=[
                        ['key'=>'id','label'=>'№'],
                        ['key'=>'org_short_name','label'=>"Сокращенное наименование органихации"],
                        ['key'=>'priority','label'=>'Приоритет'],
                        ['key'=>'object_name','label'=>"Наименование объекта, требующего кап. ремонт"],
                        ['key'=>'region','label'=>"Регион"],
                        ['key'=>'city','label'=>"Город"],
                        ['key'=>'address','label'=>"Адрес"],
                        ['key'=>'assignment','label'=>"Назначение"],
                        ['key'=>'square','label'=>"Площадь кап. ремонта (кв.м)"],
                        ['key'=>'year','label'=>"Год постройки"],
                        ['key'=>'wear','label'=>"Износ здания (%)"],
                        ['key'=>'regulation','label'=>"Предписание надзорных органов: МЧС, Роспотребнадзор и т.д. (при наличии)"],
                        ['key'=>'event_type','label'=>"Вид планируемого мероприятия"],//co-financing
                        ['key'=>'finance_sum','label'=>"Сумма бюджетного финансирования на проведение кап.ремонта (тыс. руб)"],
                        ['key'=>'coFinancing','label'=>"Софинансирование из внебюджетных источников (тыс. руб)"],
                        ['key'=>'note','label'=>"Примечание"],
                        ['key'=>'buttons','label'=>''],

                    ];
                    $ret['fieldsObjects']['fields']=[
                        ['key'=>'id','label'=>'№'],
                        ['key'=>'priority','label'=>'Приоритет'],
                        ['key'=>'region','label'=>"Субъект РФ"],
                        ['key'=>'object_name','label'=>"Наименование объекта, требующего кап. ремонт"],
                        ['key'=>'assignment','label'=>"Назначение"],
                        ['key'=>'square','label'=>"Площадь кап. ремонта (кв.м)"],
                        ['key'=>'address','label'=>"Адрес объекта"],
                        ['key'=>'year','label'=>"Год постройки"],
                        ['key'=>'wear','label'=>"Износ здания (%)"],
                        ['key'=>'regulation','label'=>"Предписание надзорных органов: МЧС, Роспотребнадзор и т.д. (при наличии)"],
                        ['key'=>'event_type','label'=>"Вид планируемого мероприятия"],//co-financing
                        ['key'=>'finance_sum','label'=>"Сумма бюджетного финансирования на проведение кап.ремонта (тыс. руб)"],
                        ['key'=>'coFinancing','label'=>"Софинансирование из внебюджетных источников (тыс. руб)"],
                        ['key'=>'note','label'=>"Примечание"],

                    ];

                    $ret['priorityObjects']['items'] = [
                        ['id'=>1],
                        ['id'=>2],
                    ];
                    $ret['reservedObjects']['items'] = [
                        ['id'=>1],
                        ['id'=>2],
                    ];
                    return $ret;
                    break;
                }
            }
        }
        return null;
    }
    public function actionGetUser(){
        if ($data = Yii::$app->getRequest()->getRawBody()){
            $data = (object)Json::decode($data);
            $user = User::find()->where(['username'=>$data->login])->one();
            return [
                'organization'=>$user->organization,
                'fio'=>$user->fio,
                'position'=>$user->position,
                'isAdmin'=> self::$cans[4]
            ];
        }
    }
}