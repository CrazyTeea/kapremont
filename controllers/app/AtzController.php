<?php

namespace app\controllers\app;


use app\models\Antiterror;
use app\models\Atz;
use app\models\AtzAddress;
use app\models\AtzFiles;
use app\models\AtzTableFour;
use app\models\AtzTableThree;
use app\models\AtzTypeActivity;
use app\models\Organizations;
use app\models\Program;
use app\models\Sub_systems_table4;
use app\models\User;
use phpDocumentor\Reflection\Type;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class AtzController extends AppController
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
        $userIdOrg = User::find()->where(['id' => Yii::$app->user->id])->one()->id_org ?? null;

        if ((int)$userIdOrg !== (int)$id_org && !empty($id_org)) {
            if (Yii::$app->user->can('dku')) {
                $organization = Organizations::find()->where(['id' => $id_org])->asArray()->one();
                $region = Organizations::find()->where(['id' => $id_org])->one()->region->region;
            } else {
                return $this->redirect("/program/main-atz/$userIdOrg");
            }
        } else {
            $organization = Organizations::find()->where(['id' => $id_org])->asArray()->one();
            $region = Organizations::find()->where(['id' => $id_org])->one()->region->region;
        }

        return $this->render('mainAtz', ['organization' => $organization ?? null, 'region' => $region ?? null]);
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
        $dataArray = Json::decode(Yii::$app->request->post('data'));


        $id_org = Yii::$app->request->post('id_org');

        foreach ($dataArray as $data) {
            if (!count($data['object'])) continue;

            $atz = AtzTableThree::findOne($data['id'] ?? null) ?? new AtzTableThree();
            $atz->id_object = $data['object']['id'];
            $atz->object = $data['object']['passport_name'];
            $atz->id_org = $id_org;
            $atz->video_system = implode('/', $data['video_system']);
            $atz->evacuation_system = implode('/', $data['evacuation_system']);
            $atz->light_system = implode('/', $data['light_system']);
            $atz->predator_system = implode('/', $data['predator_system']);
            $atz->alarm_warning_system = implode('/', $data['alarm_warning_system']);
            $atz->alarm_fire_system = implode('/', $data['alarm_fire_system']);
            $atz->phone_system = implode('/', $data['phone_system']);
            $atz->fence = implode('/', $data['fence']);
            $atz->skud = implode('/', $data['skud']);


            $atz->video_system_bud = implode('/', $data['video_system_bud']);
            $atz->evacuation_system_bud = implode('/', $data['evacuation_system_bud']);
            $atz->light_system_bud = implode('/', $data['light_system_bud']);
            $atz->predator_system_bud = implode('/', $data['predator_system_bud']);
            $atz->alarm_warning_system_bud = implode('/', $data['alarm_warning_system_bud']);
            $atz->alarm_fire_system_bud = implode('/', $data['alarm_fire_system_bud']);
            $atz->phone_system_bud = implode('/', $data['phone_system_bud']);
            $atz->fence_bud = implode('/', $data['fence_bud']);
            $atz->skud_bud = implode('/', $data['skud_bud']);

            $atz->video_system_nebud = implode('/', $data['video_system_nebud']);
            $atz->evacuation_system_nebud = implode('/', $data['evacuation_system_nebud']);
            $atz->light_system_nebud = implode('/', $data['light_system_nebud']);
            $atz->predator_system_nebud = implode('/', $data['predator_system_nebud']);
            $atz->alarm_warning_system_nebud = implode('/', $data['alarm_warning_system_nebud']);
            $atz->alarm_fire_system_nebud = implode('/', $data['alarm_fire_system_nebud']);
            $atz->phone_system_nebud = implode('/', $data['phone_system_nebud']);
            $atz->fence_nebud = implode('/', $data['fence_nebud']);
            $atz->skud_nebud = implode('/', $data['skud_nebud']);

            $atz->save(false);
        }

        // return json_encode($new->save());
        // echo "<pre>";
        // print_r($atz);
        // die;
    }

    public function actionGetFiles()
    {
        $id_org = Yii::$app->request->get('id_org');
        $id_atz = Atz::findOne(['id_program' => Program::findOne(['id_org' => $id_org])->id ?? null])->id ?? null;


        return Json::encode(AtzFiles::findAll(['id_org' => $id_org, 'id_atz' => $id_atz]));


    }

    public function actionDownloadFiles()
    {
        $id_org = Yii::$app->request->get('id_org');
        $id_atz = Atz::findOne(['id_program' => Program::findOne(['id_org' => $id_org])->id ?? null])->id ?? null;
        if (!$id_atz)
            return 'error';
        $type = Yii::$app->request->get('type');

        $file = AtzFiles::findOne(['id_org' => $id_org, 'id_atz' => $id_atz, 'type' => $type]);

        if (!$file)
            return 'file_error';
        $path = Yii::getAlias('@webroot') . "/uploads/atz_files/$id_org/";
        $path .= $file->file;

        return Yii::$app->response->sendFile($path);

    }

    public function actionSaveFile()
    {
        $id_org = Yii::$app->request->post('id_org');
        $id_atz = Atz::findOne(['id_program' => Program::findOne(['id_org' => $id_org])->id ?? null])->id ?? null;
        if (!$id_atz)
            return Json::encode(['success' => false, 'message' => 'id_atz error']);
        $type = Yii::$app->request->post('type');
        $fileD = AtzFiles::findOne(['id_atz' => $id_atz, 'id_org' => $id_org, 'type' => $type]) ?? new AtzFiles();
        $fileS = UploadedFile::getInstanceByName('file');
        if (!$fileS)
            return Json::encode(['success' => false, 'message' => 'file error']);

        $path = Yii::getAlias('@webroot') . "/uploads/atz_files/$id_org/";

        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $file_name = "file{$type}.{$fileS->extension}";
        $fileS->saveAs("{$path}{$file_name}");


        if ($fileD->isNewRecord) {
            $fileD->id_atz = $id_atz;
            $fileD->id_org = $id_org;
        }
        $fileD->file = $file_name;
        $fileD->type = $type;
        return Json::encode(['success' => $fileD->save(), 'error' => $fileD->getErrors(), 'fileS' => $fileS]);

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
        $atz = AtzTableThree::find()->where(['id_org' => 1])->all();

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

                'video_system_bud' => $this->arrayCompact($at->video_system_bud),
                'evacuation_system_bud' => $this->arrayCompact($at->evacuation_system_bud),
                'light_system_bud' => $this->arrayCompact($at->light_system_bud),
                'predator_system_bud' => $this->arrayCompact($at->predator_system_bud),
                'alarm_warning_system_bud' => $this->arrayCompact($at->alarm_warning_system_bud),
                'alarm_fire_system_bud' => $this->arrayCompact($at->alarm_fire_system_bud),
                'phone_system_bud' => $this->arrayCompact($at->phone_system_bud),
                'fence_bud' => $this->arrayCompact($at->fence_bud),
                'skud_bud' => $this->arrayCompact($at->skud_bud),

                'video_system_nebud' => $this->arrayCompact($at->video_system_nebud),
                'evacuation_system_nebud' => $this->arrayCompact($at->evacuation_system_nebud),
                'light_system_nebud' => $this->arrayCompact($at->light_system_nebud),
                'predator_system_nebud' => $this->arrayCompact($at->predator_system_nebud),
                'alarm_warning_system_nebud' => $this->arrayCompact($at->alarm_warning_system_nebud),
                'alarm_fire_system_nebud' => $this->arrayCompact($at->alarm_fire_system_nebud),
                'phone_system_nebud' => $this->arrayCompact($at->phone_system_nebud),
                'fence_nebud' => $this->arrayCompact($at->fence_nebud),
                'skud_nebud' => $this->arrayCompact($at->skud_nebud),

                'id' => $at->id,
            ];
        }

        return json_encode($toClient ?? null);
    }

    private function arrayCompact($element)
    {
        $keys = ['podved', 'dku', 'dku_choice'];
        $arr = explode('/', $element);

        if (count($arr)) {
            for ($i = 0; $i < 3; $i++) {
                $arr[$i] = $arr[$i] ?? 0;
            }
        } else $arr = [0, 0, 0];

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

        if (empty($mainArray)) return 'emptyData';



        $getOldIds = function () use ($mainArray) {
            foreach ($mainArray as $row) {
                if (isset($row['attributes']['id'])) $ids = array_merge($ids ?? [], [$row['attributes']['id']]);
            }
            return $ids ?? [];
        };

        $this->actionDestroyAtzTableFourRow($getOldIds());

        foreach ($mainArray as $mainData) {
            $mainAtzFour = new AtzTableFour();
            $mainAtzFour->id_org = $id_org;
            $mainAtzFour->card_number = $card_number;
            $mainAtzFour->stage_number = $mainData['attributes']['stage_number'];
            $mainAtzFour->stage_name = $mainData['attributes']['stage_name'];
            $mainAtzFour->method = $mainData['attributes']['method'];
            $mainAtzFour->type_document = $mainData['attributes']['type_document'];
            $mainAtzFour->name_object = $mainData['attributes']['name_object'];
            $mainAtzFour->cost_full = $mainData['attributes']['cost_full'];
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

            if ($mainAtzFour->save()) {

                foreach ($mainData['address'] as $address) {
                    $atz_address = new AtzAddress();
                    $atz_address->id_atz_table_four = $mainAtzFour->id;
                    $atz_address->passport_name = $address['passport_name'];
                    if ($atz_address->save()) {
                        foreach ($address['attributes'] as $type_event) {
                            $atz_type_activity = new AtzTypeActivity();
                            $atz_type_activity->id_atz_table_for_address = $atz_address->id;
                            $atz_type_activity->name = $type_event->name;
                            $atz_type_activity->value = $type_event->value;
                            if($atz_type_activity->save()) {
                                foreach ($mainData['attributes']['cost_budjet'] as $key_name_budjet => $budjet) {
                                    if ($key_name_budjet == $atz_type_activity->value) {
                                        $b_systems = new Sub_systems_table4();
                                        $b_systems->id_card = $mainAtzFour->id;
                                        $b_systems->cost_type = 'cost_budjet';
                                        $b_systems->field_name = $key_name_budjet;
                                        $b_systems->value = $budjet;
                                        $b_systems->save();
                                    }
                                }

                                foreach ($mainData['attributes']['cost_vb'] as $key_name_vne_budjet => $vne_budjet) {
                                    if ($key_name_vne_budjet == $atz_type_activity->value) {
                                        $b_systems = new Sub_systems_table4();
                                        $b_systems->id_card = $mainAtzFour->id;
                                        $b_systems->cost_type = 'cost_vb';
                                        $b_systems->field_name = $key_name_vne_budjet;
                                        $b_systems->value = $vne_budjet;
                                        $b_systems->save();
                                    }
                                }
                            }
                        }
                    }
                }


//                foreach ($mainData['attributes']['cost_budjet'] as $key_name_budjet => $budjet) {
//                    $b_systems = new Sub_systems_table4();
//                    $b_systems->id_card = $mainAtzFour->id;
//                    $b_systems->cost_type = 'cost_budjet';
//                    $b_systems->field_name = $key_name_budjet;
//                    $b_systems->value = $budjet;
//                    $b_systems->save();
//                }
//
//                foreach ($mainData['attributes']['cost_vb'] as $key_name_vne_budjet => $vne_budjet) {
//                    $b_systems = new Sub_systems_table4();
//                    $b_systems->id_card = $mainAtzFour->id;
//                    $b_systems->cost_type = 'cost_vb';
//                    $b_systems->field_name = $key_name_vne_budjet;
//                    $b_systems->value = $vne_budjet;
//                    $b_systems->save();
//                }
            }

        }

        return 'max pidor';
    }

    public function actionDestroyAtzTableFourRow(array $ids = null)
    {
        if (is_null($ids)) $ids = json_decode(Yii::$app->request->post('ids'));
        foreach ($ids as $id) {
            AtzTableFour::destroy($id);
        }
    }

    public function actionGetTable4()
    {
        $arrayLastRowIndex = ['.1', '.24'];
        $id_org = Yii::$app->request->post('id_org');
        $card_number = 1; //Yii::$app->request->post('card_number');

        $atz_table_four = AtzTableFour::find()->where(['id_org' => $id_org, 'card_number' => $card_number])->asArray()->all();

        $isLastRow = function ($atz_table_four_one) use ($arrayLastRowIndex) {
            return in_array($atz_table_four_one['stage_number'], $arrayLastRowIndex);
        };

        $i = 0;

        foreach ($atz_table_four as  $atz_table_four_one) {
            $addresses = AtzAddress::find()->where(['id_atz_table_four' => $atz_table_four_one['id']])->asArray()->all();

            $cost_b_dbs = Sub_systems_table4::find()->where(['id_card' => $atz_table_four_one['id'], 'cost_type' => 'cost_budjet'])->asArray()->all();
            $cost_vb_dbs = Sub_systems_table4::find()->where(['id_card' => $atz_table_four_one['id'], 'cost_type' => 'cost_vb'])->asArray()->all();


            $cost_b = [];
            $cost_vb = [];

            foreach($cost_b_dbs as $cost_b_db) {
                $cost_b[$cost_b_db['field_name']] = $cost_b_db['value'] ?? 0;
            }

            foreach($cost_vb_dbs as $cost_vb_db) {
                $cost_vb[$cost_vb_db['field_name']] = $cost_vb_db['value'] ?? 0;
            }

            $atz_table_four_one['cost_budjet'] = $cost_b ?? (object) [];
            $atz_table_four_one['cost_vb'] = $cost_vb ?? (object) [];

//            if ($i == 1) dd($atz_table_four_one['cost_vb']);

            $i++;
            $row_stages[] = array_merge($atz_table_four_one, ['address' => $addresses, 'type_event' => (function () use ($addresses) {
                foreach ($addresses as $address) {
                    $type_event = array_merge($type_event ?? [], AtzTypeActivity::find()->select(['id', 'name', 'value'])->where(['id_atz_table_for_address' => $address['id']])->asArray()->all());
                }
                return $type_event ?? [];
            })()]);

            if ($isLastRow($atz_table_four_one)) {
                $toClient [] = ['row_stages' => $row_stages];
                $row_stages = [];
            }
        }

        return json_encode($toClient ?? []);
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
