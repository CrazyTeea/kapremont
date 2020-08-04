<?php

namespace app\controllers\app;

use app\models\Antiterror;
use app\models\Atz;
use app\models\AtzAddress;
use app\models\AtzTableFour;
use app\models\AtzTableThree;
use app\models\AtzTypeActivity;
use app\models\Organizations;
use app\models\Program;
use app\models\User;
use Yii;
use yii\web\Controller;

class AtzController extends Controller
{
    public function actionIndex()
    {
        $program = Yii::$app->getSession()->get('program');
        if (!$program)
            $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
        //$atz = Atz::findAll(['id_program'=>$program->id]) ? : [new Atz()];
        $save = true;
        if (Yii::$app->request->post()) {
            $json = Yii::$app->request->post();
            foreach ($json['Atz'] as $index => $item) {
                $a = Atz::findOne(['id_program' => $program->id, 'elem' => $index]);
                if (!$a) {
                    $a = new Atz();
                    $a->id_program = $program->id;
                    $a->elem = $index;
                }
                $a->cost_b = $item['cost_b'];
                $a->cost_v = $item['cost_v'];
                $save &= $a->save();
            }
            if ($save) return 1;
            else return 0;
        }
        return $this->render('index');
    }

    public function actionMainAtz($id_org)
    {
        if (!Yii::$app->user->can('dku'))
            $id_org = $this->getCurrentOrgId();

        if (!empty($id_org)) {
            $organization = Organizations::find()->where(['id' => $id_org])->asArray()->one();
            $region = Organizations::find()->where(['id' => $id_org])->one()->region->region;
        }

        return $this->render('mainAtz', ['organization' => $organization ?? null, 'region' => $region]);
    }

    public function getCurrentOrgId()
    {
        if (!empty($id_user = Yii::$app->user->id ?? null)) {
            if (!empty($id_org = User::findOne($id_user)->id_org ?? null)) {
                return $id_org;
            }
        }

        return false;
    }

    public function actionInDev()
    {
        return $this->render('inDev.php');
    }

    public function actionSaveTable3()
    {
        $dataArray = json_decode(Yii::$app->request->post('data'));
        $id_org = Yii::$app->request->post('id_org');

        foreach ($dataArray as $data) {
            if (!empty($data->id)) continue;

            $atz = new AtzTableThree();
            $atz->id_object = $data->object->id;
            $atz->object = $data->object->passport_name;
            $atz->id_org = $id_org;
            $atz->video_system = implode('/', (array)$data->video_system);
            $atz->evacuation_system = implode('/', (array)$data->evacuation_system);
            $atz->light_system = implode('/', (array)$data->light_system);
            $atz->predator_system = implode('/', (array)$data->predator_system);
            $atz->alarm_warning_system = implode('/', (array)$data->alarm_warning_system);
            $atz->alarm_fire_system = implode('/', (array)$data->alarm_fire_system);
            $atz->phone_system = implode('/', (array)$data->phone_system);
            $atz->fence = implode('/', (array)$data->fence);
            $atz->skud = implode('/', (array)$data->skud);
            $atz->save();
        }

        // return json_encode($new->save());
        // echo "<pre>";
        // print_r($atz);
        // die;
    }

    public function actionDeleteTable3()
    {
        $id = Yii::$app->request->post('id');
        $atzRecord = AtzTableThree::findOne($id);

        return json_encode($atzRecord->delete());
    }

    public function actionGetTable3()
    {
        $id_org = Yii::$app->request->post('id_org');
        $atz = AtzTableThree::find()->where(['id_org' => $id_org])->all();
        foreach ($atz as $at) {
            $toClient[] = [
                'object' => [
                    'id' => $at->id_object,
                    'passport_name' => $at->object
                ],
                'video_system' => $this->arrayCompact($at->video_system),
                'evacuation_system' => $this->arrayCompact($at->evacuation_system),
                'light_system' => $this->arrayCompact($at->light_system),
                'predator_system' => $this->arrayCompact($at->predator_system),
                'alarm_warning_system' => $this->arrayCompact($at->alarm_warning_system),
                'alarm_fire_system' => $this->arrayCompact($at->alarm_fire_system),
                'phone_system' => $this->arrayCompact($at->phone_system),
                'fence' => $this->arrayCompact($at->fence),
                'skud' => $this->arrayCompact($at->skud),
                'id' => $at->id,
            ];
        }

        return json_encode($toClient ?? null);
    }

    private function arrayCompact($element)
    {
        $keys = ['podved', 'dku', 'dku_choice'];
        $arr = explode('/', $element);

        return array_combine($keys, $arr);
    }


    public function actionGetInfo()
    {
        $id_org = Yii::$app->request->post('id_org');

        $query = Antiterror::find()
            ->select(['id', 'passport_name'])
            ->where(['id_podved' => $id_org, 'system_status' => 1])
            ->groupBy('passport_name')
            ->asArray()
            ->all();

        return json_encode($query);
    }

    public function actionSaveTable4()
    {
        $data = json_decode(Yii::$app->request->post('data'));
        $id_org = Yii::$app->request->post('id_org');
        $card_number = Yii::$app->request->post('card_number');

        foreach ($data as $row) {
            foreach ($row->row_stages as $rowData) {
                foreach ($rowData->address as $i => $address) {
                    if (empty($address)) continue;
                    $arrayToSave[] = [
                        'passport_name' => $address->passport_name,
                        'attributes' => array_filter($rowData->type_event, function ($elem) use ($i) {
                            $value = $elem->value;
                            $num = explode('-', $value)[1];
                            return $num == $i;
                        }),
                    ];
                }
                $mainArray[] = [
                    'attributes' => array_filter((array)$rowData, function ($key) {
                        return !in_array($key, ['address', 'type_event']);
                    }, ARRAY_FILTER_USE_KEY),
                    'address' => $arrayToSave ?? [],
                ];
                $arrayToSave = [];
            }
        }

//        echo "<pre>";
//        print_r($mainArray);
//        die();

//        dd($mainArray);

        if (empty($mainArray)) return 'emptyData';

        foreach ($mainArray as $mainData) {

            $mainAtzFour = (isset($mainData['attributes']['id'])) ? AtzTableFour::find()->where(['id' => $mainData['attributes']['id']])->one() : new AtzTableFour();
            $mainAtzFour->id_org = $id_org;
            $mainAtzFour->card_number = $card_number;
            $mainAtzFour->stage_number = $mainData['attributes']['stage_number'];
            $mainAtzFour->stage_name = $mainData['attributes']['stage_name'];
            $mainAtzFour->method = $mainData['attributes']['method'];
            $mainAtzFour->type_document = $mainData['attributes']['type_document'];
            $mainAtzFour->name_object = $mainData['attributes']['name_object'];
            $mainAtzFour->cost_full = $mainData['attributes']['cost_full'];
            $mainAtzFour->cost_budjet = $mainData['attributes']['cost_budjet'];
            $mainAtzFour->cost_vb = $mainData['attributes']['cost_vb'];
            $mainAtzFour->number_contract = $mainData['attributes']['number_contract'];
            $mainAtzFour->date_doc = $mainData['attributes']['date_doc'];
            $mainAtzFour->number_deal = $mainData['attributes']['number_deal'];
            $mainAtzFour->name_deller_by_doc = $mainData['attributes']['name_deller_by_doc'];
            $mainAtzFour->inn_deller_by_doc = $mainData['attributes']['inn_deller_by_doc'];
            $mainAtzFour->date_start = $mainData['attributes']['date_start'];
            $mainAtzFour->date_end = $mainData['attributes']['date_end'];
            $mainAtzFour->docs = $mainData['attributes']['docs'];
            $mainAtzFour->comment_vuz = $mainData['attributes']['comment_vuz'];
            $mainAtzFour->mon_expert = $mainData['attributes']['mon_expert'];
            $mainAtzFour->comment_mon = $mainData['attributes']['comment_mon'];

            // echo "<pre>";
            // print_r($mainAtzFour);
            // die;

            if ($mainAtzFour->save()) {
                foreach ($mainData['address'] as $address) {
                    $atz_address = (isset($address['id'])) ? AtzAddress::find()->where(['id' => $address['id']])->one() : new AtzAddress();
                    $atz_address->id_atz_table_four = $mainAtzFour->id;
                    $atz_address->passport_name = $address['passport_name'];
                    if ($atz_address->save()) {
                        foreach ($address['attributes'] as $type_event) {
                            $atz_type_activity = new AtzTypeActivity();
                            $atz_type_activity->id_atz_table_for_address = $atz_address->id;
                            $atz_type_activity->name = $type_event->name;
                            $atz_type_activity->value = $type_event->value;
                            $atz_type_activity->save();
                            // if ($atz_type_activity->save()) return json_encode('saved');
                        }
                    }
                }
            }
        }

        return 'error';
        echo "<pre>";
        print_r($mainArray);
        die();
    }

    public function actionGetTable4()
    {
//        $arry1 = ['Закупка не конкурентный способом /Заключение договора /контракта ', 'Исполнение договора /контракта'];
//        $array2 = ['Закупка конкурентный способом', 'Подведение итогов по закупке', 'Заключение договора /контракта', 'Исполнение договора /контракта'];

        $array1Numbers = [null, '.1'];
        $array2Numbers = ['.2', '.21', '.23', '.24'];




        $id_org = 100; //Yii::$app->request->post('id_org');
        $card_number = 1; //Yii::$app->request->post('card_number');

        $atz_table_four = AtzTableFour::find()->where(['id_org' => $id_org, 'card_number' => $card_number])->asArray()->all();

//        dump($atz_table_four);

        $compactIDs = (function () use ($atz_table_four) {
            $lastIndex = count($atz_table_four) - 1;
//            dd(is_null($atz_table_four[0]['stage_number']));

            if (is_null($atz_table_four[0]['stage_number'])) {
                var_dump($atz_table_four[0]['stage_number']);
            }
        })();

        foreach ($atz_table_four as $atz_table_four_one) {
            $addresses = AtzAddress::find()->where(['id_atz_table_four' => $atz_table_four_one['id']])->asArray()->all();
            $row_stages[] = array_merge($atz_table_four_one, ['address' => $addresses, 'type_event' => (function () use ($addresses) {
                foreach ($addresses as $address) {
                    $type_event = array_merge($type_event ?? [], AtzTypeActivity::find()->select(['id', 'name', 'value'])->where(['id_atz_table_for_address' => $address['id']])->asArray()->all());
                }
                return $type_event ?? [];
            })()]);
            // echo "<pre>";
            // print_r($addresses);
            // die();
            // echo "<pre>";
            // print_r($atz_table_four_one);
            // die();
        }
        return json_encode([
            'row_stages' => $row_stages ?? []
        ]);
    }

    public function actionSecretMethod()
    {
        // $old = Antiterror::find()
        //     ->select(['id_podved', 'passport_name'])
        //     ->where(['system_status' => 1])
        //     ->groupBy(['id_podved', 'passport_name'])
        //     ->all();

        //     // echo"<pre>";
        //     // print_r($);
        //     // die;

        // foreach($old as $arr) {
        //     $new = new AntiterrorPassport();
        //     $new->id_org = $arr->id_podved;
        //     $new->name_address = $arr->passport_name;
        //     $old_ids = Antiterror::find()
        //         ->select('id_object')
        //         ->where(['id_podved' => $arr->id_podved, 'system_status' => 1])
        //         ->asArray()
        //         ->all();
        //     if(!empty($old_ids)) {
        //         foreach($old_ids as $old_id) {
        //             $sub[] = $old_id['id_object'];
        //         }
        //     }
        //         $old_ids = implode(',', $sub);

        //     $new->old_ids = $old_ids;

        //     $old_ids = [];
        //     $sub = [];

        //     try {
        //         $new->save();
        //     } catch (Exception $e) {
        //         continue;
        //     }

        // }

        // echo"<pre>";
        // print_r($new);
        // die;
    }
}
