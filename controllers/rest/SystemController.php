<?php


namespace app\controllers\rest;


use app\models\Atz;
use app\models\Cities;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\ProgObjectsEvents;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\Regions;
use app\models\User;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/***
 * Class SystemController
 * @package app\controllers\rest
 * @property User $user
 */

class SystemController extends RestController
{
    protected $user;
    public function beforeAction($action)
    {
        $this->user = Yii::$app->getSession()->get('user');
        return parent::beforeAction($action);
    }

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
                    $id_org = Yii::$app->session->get('user')->id_org;
                    $program = Program::findOne(['id_org'=>$id_org]);
                    Yii::$app->getSession()->set('program',$program);
                    if (!$program)
                        return null;
                    $ret['items'] = [
                        ['id' => 1, 'label' =>
                            "Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов,тыс. рублей",
                            'value' => round( $program->finance_volume,2)
                        ],
                    ];
                    if (!Yii::$app->getUser()->can('faiv_user')){
                        $ret['items'] = ArrayHelper::merge($ret['items'], [

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
                                ]
                            ]
                        );
                    }

                    return $ret;
                    break;
                }
                case 'programView':{
                    $ret['objects']['fields']=[
                        ['key'=>'index','label'=>'№'],
                        ['key'=>'org_short_name','label'=>"Сокращенное наименование органихации"],
                        ['key'=>'priority','label'=>'Приоритет'],
                        ['key'=>'name','label'=>"Наименование объекта, требующего кап. ремонт"],
                        ['key'=>'id_region','label'=>"Регион"],
                        ['key'=>'id_city','label'=>"Город"],
                        ['key'=>'address','label'=>"Адрес"],
                        ['key'=>'assignment','label'=>"Назначение"],
                        ['key'=>'square_kap','label'=>"Площадь кап. ремонта (кв.м)"],
                        ['key'=>'year','label'=>"Год постройки"],
                        ['key'=>'wear2','label'=>"Износ здания (%)"],
                        ['key'=>'regulationT','label'=>"Предписание надзорных органов: МЧС, Роспотребнадзор и т.д. (при наличии)"],
                        ['key'=>'event_type','label'=>"Вид планируемого мероприятия"],//co-financing
                        ['key'=>'finance_sum','label'=>"Сумма бюджетного финансирования на проведение кап.ремонта (тыс. руб)"],
                        ['key'=>'coFinancing','label'=>"Софинансирование из внебюджетных источников (тыс. руб)"],
                        ['key'=>'note','label'=>"Примечание"],


                    ];
                    $ret['fieldsObjects']['fields']=[
                        ['key'=>'index','label'=>'№'],
                        ['key'=>'type2','label'=>'Тип'],
                        ['key'=>'priority','label'=>'Приоритет'],
                        ['key'=>'region','label'=>"Субъект РФ"],
                        ['key'=>'name','label'=>"Наименование объекта, требующего кап. ремонт"],
                        ['key'=>'assignment','label'=>"Назначение"],
                        ['key'=>'square_kap','label'=>"Площадь кап. ремонта (кв.м)"],
                        ['key'=>'address','label'=>"Адрес объекта"],
                        ['key'=>'year','label'=>"Год постройки"],
                        ['key'=>'wear2','label'=>"Износ здания (%)"],
                        ['key'=>'regulationT','label'=>"Предписание надзорных органов: МЧС, Роспотребнадзор и т.д. (при наличии)"],
                        ['key'=>'event_typeT','label'=>"Вид планируемого мероприятия"],//co-financing
                        ['key'=>'finance_sum','label'=>"Сумма бюджетного финансирования на проведение кап.ремонта (тыс. руб)"],
                        ['key'=>'coFinancing','label'=>"Софинансирование из внебюджетных источников (тыс. руб)"],
                        ['key'=>'note','label'=>"Примечание"],


                    ];
                    $ret['target']['fields'] = [
                        ['key'=>'id','label'=>'№'],
                        ['key'=>'target','label'=>'Цели и задачи'],
                        ['key'=>'indicator','label'=>"Планируемый показатель"],
                        ['key'=>'unit','label'=>"Единица измерения"],
                    ];
                    $ret['target']['items'] = [
                        ['id'=>1,'target'=>'Проведение капитального ремонта, общая площадь','indicator'=>'','unit'=>'кв.м'],
                        ['id'=>2,'target'=>'Вовлечение в хоз. деятельность за счет проведенного кп. ремонта, общая площадь','indicator'=>'','unit'=>'кв.м'],
                        ['id'=>3,'target'=>'Снижение затрат на эксплуатацию, общая площадь','indicator'=>'','unit'=>'да/нет'],
                        ['id'=>4,'target'=>'Повышение энергоэффективности','indicator'=>'','unit'=>'да/нет'],
                        ['id'=>5,'target'=>'Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия','indicator'=>'','unit'=>'да/нет'],
                        ['id'=>6,'target'=>'Иное:','indicator'=>'','unit'=>''],
                    ];

                    $progObj = ProgramObjects::find()->where(['system_status'=>1,'id_org'=>$this->user->id_org,'type'=>0])->joinWith(['region'])->orderBy(['created_at'=>SORT_ASC])->all();
                    $flag = false;
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
                    $r = [
                      'Комплексный',
                      'Выборочный'
                    ];
                    $s_sum = 0; $sum_sum = 0;
                    foreach ($progObj as $index=>$item) {
                        $i = $index+1;
                        $s_sum += floatval($item->square_kap );
                        $sum_sum += floatval($item->finance_sum);
                        $ret['priorityObjects']['items'][$index] = ArrayHelper::merge([
                            'type2'=>'Приоритетный',
                            'event_typeT'=>(isset($item->type_remont) ? $r[$item->type_remont] : ''),
                            'regulationT'=>($item->exist_pred_nadz_orgs) ? $item->regulation : '',
                            'index'=>$i,
                            'priority'=> $prior[$item->id_priority ? : 1],
                            'region' => $item->region ? $item->region->region : '',
                            'wear2'=> (!is_null($item->wear) and $item->wear < 5 )? $wear[$item->wear] : ''
                        ],$item
                        );
                    }
                    if (isset($ret['priorityObjects']['items'])) {
                        array_push($ret['priorityObjects']['items'], ['assignment' => 'итого',
                            'square_kap' => number_format($s_sum, 3, '.',' ') ,
                            'finance_sum' => number_format($sum_sum, 3, '.',' ')]);
                    }
                    $s_sum = 0; $sum_sum = 0;
                    $progObj = ProgramObjects::find()->where(['system_status'=>1,'id_org'=>$this->user->id_org,'type'=>1])->joinWith(['region'])->all();
                    foreach ($progObj as $index=>$item) {
                        $i = $index+1;
                        $s_sum += floatval($item->square_kap );
                        $sum_sum += floatval($item->finance_sum);
                        $ret['reservedObjects']['items'][$index] = ArrayHelper::merge([
                            'type2'=>'Резервный',
                            'event_typeT'=>(isset($item->type_remont) ? $r[$item->type_remont] : ''),
                            'regulationT'=>($item->exist_pred_nadz_orgs) ? $item->regulation : '',
                            'index'=>$i,
                            'priority'=> $prior[$item->id_priority ? : 1],
                            'region' =>$item->region ? $item->region->region : '',
                            'wear2'=> (!is_null($item->wear) and $item->wear < 5) ? $wear[$item->wear] : ''
                        ],$item);
                    }
                    if (isset($ret['reservedObjects']['items'])) {
                        array_push($ret['reservedObjects']['items'], ['assignment' => 'итого', 'square_kap' => number_format($s_sum, 3, '.',' ') , 'finance_sum' => number_format($sum_sum, 3, '.',' ')]);
                    }

                    return $ret;
                }
                case 'objectCreate':{
                    $ret['regionOptions'] = Regions::find()->all();
                    $ret['cityOptions'] = Cities::find()->all();
                    $ret['_csrf'] = Yii::$app->request->getCsrfToken();
                    $ret['headers'] = Yii::$app->getRequest()->getHeaders();
                    return $ret;
                    break;
                }
                case 'orgInfo':{
                    $ret['fields'] = [
                        ['key'=>'id','label'=>'#'],
                        ['key'=>'label','label'=>'Показатель'],
                        ['key'=>'value','label'=>'Значение']
                    ];

                    $org = Organizations::findOne(Yii::$app->session->get('user')->id_org);

                    $ret['items'] = [
                        ['id' => 1, 'label' =>
                            "Полное наименование организации",
                            'value' => $org->full_name
                        ],
                        ['id' => 2, 'label' =>
                            "Сокращенное наименование организации",
                            'value' => $org->short_name
                        ],
                    ];
                    if (!Yii::$app->getUser()->can('faiv_user'))
                        $ret['items'] = ArrayHelper::merge($ret['items'],
                            [
                                ['id' => 3, 'label' =>
                                    "Общая численность обучающихся по программам среднего профессионального образования, бакалавриата, специалитета, магистратуры, аспирантуры, включая очную и заочную формы обучения, из них:",
                                    'value' => $org->orgInfo?$org->orgInfo->st_sr_count: 0
                                ],
                                ['id' => 3.1, 'label' =>
                                    "Численность обучающихся за счет средств федерального бюджета",
                                    'value'=>  $org->orgInfo?$org->orgInfo->st_fed_count: 0
                                ],
                                ['id' => 3.2, 'label' =>
                                    "Численность обучающихся по договору с полным возмещением затрат",
                                    'value' => $org->orgInfo?$org->orgInfo->st_dog_count: 0
                                ],
                                ['id' => 3.3, 'label' =>
                                    "Общая численность обучающихся иностранных граждан и лиц без гражданства",
                                    'value' => $org->orgInfo?$org->orgInfo->st_in_count: 0
                                ],
                                ['id' => 4, 'label' =>
                                    "Численность профессорско-преподавательского состава",
                                    'value'=>  $org->orgInfo?$org->orgInfo->prof_count: 0
                                ],
                                ['id' => 5, 'label' =>
                                    "Студенты всего, из них:",
                                    'value' => ($org->orgInfo) ?
                                        floatval($org->orgInfo->st_sr_pr_count) +
                                        floatval($org->orgInfo->st_bak_count) +
                                        floatval($org->orgInfo->st_spec_count) +
                                        floatval($org->orgInfo->st_mag_count) +
                                        floatval($org->orgInfo->st_asp_count)
                                        : 0
                                ],
                                ['id' => 5.1, 'label' =>
                                    "Среднего профессионального образования",
                                    'value' => $org->orgInfo?$org->orgInfo->st_sr_pr_count: 0
                                ],
                                ['id' => 5.2, 'label' =>
                                    "Бакалавриата",
                                    'value'=>  $org->orgInfo?$org->orgInfo->st_bak_count: 0
                                ],
                                ['id' => 5.3, 'label' =>
                                    "Специалитета",
                                    'value' => $org->orgInfo?$org->orgInfo->st_spec_count: 0
                                ],
                                ['id' => 5.4, 'label' =>
                                    "Магистратуры",
                                    'value' => $org->orgInfo?$org->orgInfo->st_mag_count: 0
                                ],
                                ['id' => 5.5, 'label' =>
                                    "Аспирантуры",
                                    'value'=>  $org->orgInfo?$org->orgInfo->st_asp_count: 0
                                ],
                                ['id' => 6, 'label' =>
                                    "Работники, из них:",
                                    'value' => $org->orgInfo?$org->orgInfo->rab_count: 0
                                ],
                                ['id' => 6.1, 'label' =>
                                    "Научные сотрудники",
                                    'value' => $org->orgInfo?$org->orgInfo->nauch_rab: 0
                                ],
                                ['id' => 6.2, 'label' =>
                                    "Профессорско-преподавательский состав",
                                    'value'=>  $org->orgInfo?$org->orgInfo->prof_prep_count: 0
                                ],
                                ['id' => 6.3, 'label' =>
                                    "Иные категории работников",
                                    'value'=>  $org->orgInfo?$org->orgInfo->in_kat_rab: 0
                                ],
                                ['id' => 7, 'label' =>
                                    "Численность инвалидов и лиц с ограниченными возможностями здоровья",
                                    'value'=>  $org->orgInfo?$org->orgInfo->invalid_count: 0
                                ],
                                ['id' => 8, 'label' =>
                                    "Общая площадь всех зданий и сооружений",
                                    'value'=> ($org->orgInfo)? $org->orgInfo->square_all: 0
                                ],
                                ['id' => 9, 'label' =>
                                    "Общая площадь всех зданий и сооружений, требующих капитального ремонта (на основании акта обследования или предписаний надзорных органов)",
                                    'value'=>  ($org->orgInfo)? $org->orgInfo->square_all_kap: 0
                                ],
                                ['id' => 10, 'label' =>
                                    "Общая площадь всех зданий и сооружений, находящихся в аварийном состоянии (на основании акта обследования или предписаний надзорных органов)",
                                    'value'=>  $org->orgInfo? $org->orgInfo->square_all_av: 0
                                ],
                                ['id' => 11, 'label' =>
                                    "Общая площадь всех зданий и сооружений, требующих мероприятий по АТЗ",
                                    'value'=>  $org->orgInfo? $org->orgInfo->square_all_atz: 0
                                ],
                                ['id' => 12, 'label' =>
                                    "ФИО ректора",
                                    'value'=>  $org->orgInfo? $org->orgInfo->rector: ''
                                ],
                            ]
                        );
                    else
                        $ret['items'] = ArrayHelper::merge($ret['items'],
                            [
                                ['id' => 3, 'label' =>
                                    "ИНН",
                                    'value' => $org->inn
                                ],
                            ]
                        );

                    return $ret;
                }
                case 'atz':{
                    $program = Yii::$app->session->get('program');
                    if (!$program)
                        $program = Program::findOne(['id_org'=>Yii::$app->session->get('user')->id_org]);
                    $atz = Atz::findAll(['id_program'=>$program->id]);
                    return $atz;
                }
            }
        }
        return null;
    }
    public function actionGetUser(){
        if (!Yii::$app->getUser()->isGuest) {

            //$data = (object)Json::decode($data);
            //$user = User::find()->where(['username' => $data->login])->one();
            $user = Yii::$app->getSession()->get('user');
            return [
                'organization' => $user->organization,
                'fio' => $user->fio,
                'position' => $user->position,
                'isAdmin' => self::$cans[5]
            ];

        }
    }
}