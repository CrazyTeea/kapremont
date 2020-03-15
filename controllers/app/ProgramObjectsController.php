<?php

namespace app\controllers\app;

use app\models\Files;
use app\models\ObjectDocumentsList;
use app\models\ObjectDocumentsTypes;
use app\models\ProgObjectsEvents;
use app\models\ProgObjectsRiscs;
use app\models\ProgObjectsWaites;
use app\models\ProObjectsNecessary;
use Yii;
use app\models\ProgramObjects;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProgramObjectsController implements the CRUD actions for ProgramObjects model.
 */
class ProgramObjectsController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProgramObjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single ProgramObjects model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $docList = ObjectDocumentsList::findAll(['system_status'=>1,'id_object'=>$id]);
        return $this->render('view',compact('model','docList'));
    }
    public function actionDownloadDoc($id_obj){
        $get= Yii::$app->request->get();
        $file = Files::findOne($get['id']);
        if (!$file)
            return $this->goBack();
        $path =  $path = Yii::getAlias( '@webroot' ) . '/uploads/'.$id_obj;
        return Yii::$app->response->sendFile("$path/{$file->name}.{$file->ext}")->send();
    }

    /**
     * Creates a new ProgramObjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new ProgramObjects();
        $progObjectsEvents = [new ProgObjectsEvents()];
        $proObjectsNecessary = [new ProObjectsNecessary()];
        $progObjectsWaites =  [new ProgObjectsWaites()];
        $progObjectsRiscs =  [new ProgObjectsRiscs()];
        $objectDocsTypes = ObjectDocumentsTypes::find()->all();
        $save = true;
        $model->id_org = Yii::$app->session->get('user')->id_org;
        $program = Yii::$app->session->get('program');
        if (!$program)
            return $this->redirect(['/']);
        $model->id_program = $program->id;
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                if ($model->id_priority == 4)
                    $model->type = 1;
                else $model->type = 0;
                $transaction = Yii::$app->getDb()->beginTransaction();
                $save &= $model->save();
                $errors['ProgramObjects'] = $model->getErrors();
                if ($save) {
                    $progObjectsEvents = ProgObjectsEvents::createMultiple(ProgObjectsEvents::className(), $progObjectsEvents);
                    ProgObjectsEvents::loadMultiple($progObjectsEvents, Yii::$app->request->post());

                    foreach ($progObjectsEvents as $index => $item) {
                        $pr = ProgObjectsEvents::findOne(['id_object' => $model->id, 'step' => $index]);
                        if (!$pr) {
                            $pr = new ProgObjectsEvents();
                            $pr->id_object = $model->id;
                            $pr->step = $index;
                        }

                        $pr->date_event_end = $item->date_event_end;
                        $pr->date_event_start = $item->date_event_start;
                        $pr->is_nessesary = $item->is_nessesary;
                        $pr->cost_real = $item->cost_real;
                        $pr->sum_bud_fin = $item->sum_bud_fin;
                        $pr->fin_vnebud_ist = $item->fin_vnebud_ist;
                        $model->finance_sum+=floatval($pr->sum_bud_fin);
                        $model->coFinancing+=floatval($pr->fin_vnebud_ist);
                        $save &= $pr->save();
                        $errors['ProgObjectsEvents'][] = $pr->getErrors();
                    }
                    $save &= $model->save(false);
                    // $deletedIDs = null;
                    //$oldIds = ArrayHelper::map($proObjectsNecessary,'id','id');
                    $proObjectsNecessary = ProObjectsNecessary::createMultiple(ProObjectsNecessary::className(), $proObjectsNecessary);
                    ProObjectsNecessary::loadMultiple($proObjectsNecessary, Yii::$app->request->post());
                    if (  is_array(Yii::$app->request->post('ProObjectsNecessary'))){
                        foreach (Yii::$app->request->post('ProObjectsNecessary') as $index => $item) {
                            if (!ArrayHelper::keyExists($index, $proObjectsNecessary)) {
                                $proObjectsNecessary[$index] = new ProObjectsNecessary();

                            }
                            $proObjectsNecessary[$index]['nalichie'] = isset($item['nalichie']) ? $item['nalichie'] : 0;
                            $proObjectsNecessary[$index]['material'] = isset($item['material']) ? $item['material'] : '';
                            $proObjectsNecessary[$index]['srok_eks'] = isset($item['srok_eks']) ? $item['srok_eks'] : '';
                            $proObjectsNecessary[$index]['kap_remont'] = isset($item['kap_remont']) ? $item['kap_remont'] : 0;
                            $proObjectsNecessary[$index]['obosnovanie'] = isset($item['obosnovanie']) ? $item['obosnovanie'] : '';;
                            $proObjectsNecessary[$index]['element'] = isset($item['element']) ? $item['element'] : '';
                        }
                    }
                    // $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($proObjectsNecessary, 'id', 'id')));
                    // if (! empty($deletedIDs))
                    //     ProObjectsNecessary::deleteAll(['id' => $deletedIDs]);

                    foreach ($proObjectsNecessary as $index => $item) {

                        $pr = ProObjectsNecessary::findOne(['id_object' => $model->id, 'element' => $item->element]);
                        if (!$pr){
                            $pr = new ProObjectsNecessary();
                            $pr->id_object = $model->id;
                            $pr->element = $item->element;
                        }
                        $pr->nalichie = (int)$item->nalichie;
                        $pr->material = $item->material;
                        $pr->srok_eks = $item->srok_eks;
                        $pr->kap_remont = (int)$item->kap_remont;
                        $pr->obosnovanie = $item->obosnovanie;

                        $save &= $pr->save();
                        $errors['ProObjectsNecessary'][] = $pr->getErrors();
                    }

                  //  $deletedIDs = null;
                   // $oldIds = ArrayHelper::map($progObjectsWaites,'id','id');
                    $progObjectsWaites = ProgObjectsWaites::createMultiple(ProgObjectsWaites::className(), $progObjectsWaites);
                    ProgObjectsWaites::loadMultiple($progObjectsWaites, Yii::$app->request->post());
                   // $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($progObjectsWaites, 'id', 'id')));
                   // if (! empty($deletedIDs))
                   //     ProgObjectsWaites::deleteAll(['id' => $deletedIDs]);
                    foreach ($progObjectsWaites as $index => $item) {
                        $pr = ProgObjectsWaites::findOne(['id_object' => $model->id, 'element' => $index]);
                        if (!$pr) {
                            $pr = new ProgObjectsWaites();
                            $pr->id_object = $model->id;
                            $pr->element = $index;
                        }
                        $pr->aim = $item->aim ? : $index;
                        $pr->plan = $item->plan;
                        $pr->changes = $item->changes ? : '';
                        $save &= $pr->save();
                        $errors['ProgObjectsWaites'][] = [$pr->getErrors()];
                    }
                //    $oldIds = ArrayHelper::map($progObjectsRiscs,'id','id');
                    $progObjectsRiscs = ProgObjectsRiscs::createMultiple(ProgObjectsRiscs::className(), $progObjectsRiscs);
                    ProgObjectsRiscs::loadMultiple($progObjectsRiscs, Yii::$app->request->post());
                //    $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($progObjectsWaites, 'id', 'id')));
                 //   if (! empty($deletedIDs))
                  //      ProgObjectsRiscs::deleteAll(['id' => $deletedIDs]);
                    foreach ($progObjectsRiscs as $index => $item) {
                        $pr = ProgObjectsRiscs::findOne(['id_object' => $model->id, 'element' => $index]);
                        if (!$pr){
                            $pr = new ProgObjectsRiscs();
                            $pr->id_object = $model->id;
                            $pr->element = $index;
                        }
                        $pr->types = $item->types;
                        $pr->poison = $item->poison;
                        $pr->protect = $item->protect ;
                        $save &= $pr->save();
                        $errors['ProgObjectsWaites'][] = [$pr->getErrors()];
                    }
                }
                if ($save) {
                    $transaction->commit();
                    return Json::encode($model);
                } else {
                    $transaction->rollBack();
                    return Json::encode($errors);
                }
            }
        }
        return $this->render('create',compact('model','progObjectsEvents','progObjectsWaites','progObjectsRiscs','proObjectsNecessary'));
    }

    /**
     * Updates an existing ProgramObjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $progObjectsEvents = ProgObjectsEvents::findAll(['id_object'=>$id])? : [new ProgObjectsEvents()];
        $proObjectsNecessary = ProObjectsNecessary::findAll(['id_object'=>$id])? : [new ProObjectsNecessary()];
        $progObjectsWaites = ProgObjectsWaites::findAll(['id_object'=>$id])? : [new ProgObjectsWaites()];
        $progObjectsRiscs = ProgObjectsRiscs::findAll(['id_object'=>$id])? : [new ProgObjectsRiscs()];
        $save = true;
        //
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                if ($model->id_priority == 4)
                    $model->type = 1;
                else $model->type = 0;
                $transaction = Yii::$app->getDb()->beginTransaction();
                $save &= $model->save();
                $errors['ProgramObjects'] = $model->getErrors();
                $model->finance_sum = $model->coFinancing = 0;
                if ($save) {
                    $progObjectsEvents = ProgObjectsEvents::createMultiple(ProgObjectsEvents::className(), $progObjectsEvents);
                    ProgObjectsEvents::loadMultiple($progObjectsEvents, Yii::$app->request->post());

                    foreach ($progObjectsEvents as $index => $item) {
                        $pr = ProgObjectsEvents::findOne(['id_object' => $model->id, 'step' => $index]);
                        if (!$pr) {
                            $pr = new ProgObjectsEvents();
                            $pr->id_object = $id;
                            $pr->step = $index;
                        }

                        $pr->date_event_end = $item->date_event_end;
                        $pr->date_event_start = $item->date_event_start;
                        $pr->is_nessesary = $item->is_nessesary;
                        $pr->cost_real = $item->cost_real;
                        $pr->sum_bud_fin = $item->sum_bud_fin;
                        $pr->fin_vnebud_ist = $item->fin_vnebud_ist;
                        $model->finance_sum+=floatval($pr->sum_bud_fin);
                        $model->coFinancing+=floatval($pr->fin_vnebud_ist);
                        $save &= $pr->save();
                        $errors['ProgObjectsEvents'][] = $pr->getErrors();
                    }
                    $save &= $model->save(false);
                   // $deletedIDs = null;
                    //$oldIds = ArrayHelper::map($proObjectsNecessary,'id','id');
                    $proObjectsNecessary = ProObjectsNecessary::createMultiple(ProObjectsNecessary::className(), $proObjectsNecessary);
                    ProObjectsNecessary::loadMultiple($proObjectsNecessary, Yii::$app->request->post());
                    if (  is_array(Yii::$app->request->post('ProObjectsNecessary'))){
                    foreach (Yii::$app->request->post('ProObjectsNecessary') as $index => $item) {
                        if (!ArrayHelper::keyExists($index, $proObjectsNecessary)) {
                            $proObjectsNecessary[$index] = new ProObjectsNecessary();
                        }
                        $proObjectsNecessary[$index]['nalichie'] = isset($item['nalichie']) ? $item['nalichie'] : 0;
                        $proObjectsNecessary[$index]['material'] = isset($item['material']) ? $item['material'] : '';
                        $proObjectsNecessary[$index]['srok_eks'] = isset($item['srok_eks']) ? $item['srok_eks'] : '';
                        $proObjectsNecessary[$index]['kap_remont'] = isset($item['kap_remont']) ? $item['kap_remont'] : 0;
                        $proObjectsNecessary[$index]['obosnovanie'] = isset($item['obosnovanie']) ? $item['obosnovanie'] : '';;
                        $proObjectsNecessary[$index]['element'] = isset($item['element']) ? $item['element'] : '';
                    }
                }
                   // $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($proObjectsNecessary, 'id', 'id')));
                   // if (! empty($deletedIDs))
                   //     ProObjectsNecessary::deleteAll(['id' => $deletedIDs]);

                    foreach ($proObjectsNecessary as $index => $item) {

                        $pr = ProObjectsNecessary::findOne(['id_object' => $model->id, 'element' => $item->element]);
                        if (!$pr){
                            $pr = new ProObjectsNecessary();
                            $pr->id_object = $id;
                            $pr->element = $item->element;
                        }
                        $pr->nalichie = (int)$item->nalichie;
                        $pr->material = $item->material;
                        $pr->srok_eks = $item->srok_eks;
                        $pr->kap_remont = (int)$item->kap_remont;
                        $pr->obosnovanie = $item->obosnovanie;

                        $save &= $pr->save();
                        $errors['ProObjectsNecessary'][] = $pr->getErrors();
                    }

                    $deletedIDs = null;
                    $oldIds = ArrayHelper::map($progObjectsWaites,'id','id');
                    $progObjectsWaites = ProgObjectsWaites::createMultiple(ProgObjectsWaites::className(), $progObjectsWaites);
                    ProgObjectsWaites::loadMultiple($progObjectsWaites, Yii::$app->request->post());
                    $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($progObjectsWaites, 'id', 'id')));
                    if (! empty($deletedIDs))
                        ProgObjectsWaites::deleteAll(['id' => $deletedIDs]);
                    foreach ($progObjectsWaites as $index => $item) {
                        $pr = ProgObjectsWaites::findOne(['id_object' => $model->id, 'element' => $index]);
                        if (!$pr) {
                            $pr = new ProgObjectsWaites();
                            $pr->id_object = $id;
                            $pr->element = $index;
                        }
                        $pr->aim = $item->aim ? : $index;
                        $pr->plan = $item->plan;
                        $pr->changes = $item->changes ? : '';
                        $save &= $pr->save();
                        $errors['ProgObjectsWaites'][] = [$pr->getErrors()];
                    }
                    $oldIds = ArrayHelper::map($progObjectsRiscs,'id','id');
                    $progObjectsRiscs = ProgObjectsRiscs::createMultiple(ProgObjectsRiscs::className(), $progObjectsRiscs);
                    ProgObjectsRiscs::loadMultiple($progObjectsRiscs, Yii::$app->request->post());
                    $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($progObjectsWaites, 'id', 'id')));
                    if (! empty($deletedIDs))
                        ProgObjectsRiscs::deleteAll(['id' => $deletedIDs]);
                    foreach ($progObjectsRiscs as $index => $item) {
                        $pr = ProgObjectsRiscs::findOne(['id_object' => $model->id, 'element' => $index]);
                        if (!$pr){
                            $pr = new ProgObjectsRiscs();
                            $pr->id_object = $id;
                            $pr->element = $index;
                        }
                        $pr->types = $item->types;
                        $pr->poison = $item->poison;
                        $pr->protect = $item->protect;
                        $save &= $pr->save();
                        $errors['ProgObjectsWaites'][] = [$pr->getErrors()];
                    }
                }
                if ($save) {
                    $transaction->commit();
                    return Json::encode($model);
                } else {
                    $transaction->rollBack();
                    return Json::encode($errors);
                }
            }
        }
        return $this->render('update',compact('model','progObjectsEvents','progObjectsWaites','progObjectsRiscs','proObjectsNecessary'));
    }

    public function actionAddDocs($id){
        $model = $this->findModel($id);
        if($model) {
            if (Yii::$app->request->post())
            {
                if (isset(Yii::$app->request->post()['descriptor'])){
                    $des = Yii::$app->request->post()['descriptor'];
                    $obt = ObjectDocumentsTypes::findOne(['descriptor'=>$des]);
                    if (!$obt){
                        $obt = new ObjectDocumentsTypes();
                        $obt->descriptor = $des;
                        $obt->label=$des;
                        $obt->save();
                    }
                }
            }
            $docs = ObjectDocumentsTypes::find()->all();
            $done = false;
            foreach ($docs as $doc) {
                $file = UploadedFile::getInstanceByName("$doc->descriptor");
                if (!$file)
                    continue;
                $objDoc = new ObjectDocumentsList();
                $label = (isset(Yii::$app->request->post()['label'])) ? Yii::$app->request->post()['label'] : 'kek';
                if (!$objDoc->add($file,$id,$doc->id,$label)) {
                    $done = false;
                    break;
                }else
                    $done = true;
            }
            if ($done)
                return 1;
        }

        return 0;
    }

    public function actionGetAllObjFiles($id)
    {
        $toSend = null;
        $obj = ProgramObjects::find()->where(['id' => $id])
            ->select(['id', 'name'])
            ->with([
                'docList' => function($query) { return $query->where(['system_status' => 1]); },
                'docList.files' => function($query) { return $query->select(['id', 'name']); },
                'docList.types' => function($query) { return $query->select(['id', 'descriptor']); }])
            ->one();
        //$i = 0;
    //    return Json::encode($obj->docList[0]->files);
        foreach($obj->docList as $i=>$file) {
            $toSend[$i] = [
                'name' =>  $file->files[0]->name,
                'descriptor' => $file->types[0]->descriptor,
                'label'=>$file->label
            ];
          //  $i++;
        }

        // echo "<pre>";
         return Json::encode($toSend);

    }

    public function actionDeleteDocs($id)
    {

        $descriptor = Yii::$app->request->get('descriptor');

        $list_obj_id = Yii::$app->db->createCommand("
            select 
                list.id, list.system_status
            from object_documents_list as list 
                join program_objects as obj on list.id_object = obj.id
            where obj.id = '$id' and list.id_type in (select id from object_documents_types where descriptor = '$descriptor')
        ")->queryAll();

        if ($list_obj_id){
            foreach ($list_obj_id as $item){
                $kek = ObjectDocumentsList::findOne($item['id']);
                $kek->system_status = 0;
                $kek->save(false);
            }
        }


        // echo "<pre>";
        // print_r($list_obj_id[0]['id']);
         return Json::encode($kek);
    }

    public function actionDelete($id){
        $model = $this->findModel($id);
        $model->system_status = 0;
        $model->save(false);
        return $this->redirect(['program/view']);
    }

    protected function findModel($id)
    {
        if (($model = ProgramObjects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFileUpload()
    {
        $files = Files::find()->where(['files.id'=>1])->select(['name'])->joinWith(['docList'])->one();
        var_dump($files);
    }
}
