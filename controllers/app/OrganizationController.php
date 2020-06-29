<?php

namespace app\controllers\app;

use app\facades\ProgramStatus;
use app\models\ApproveStatus;
use app\models\Comments;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\ProgObjectsEvents;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
use app\models\UserInfo;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class OrganizationController extends AppController
{
    public function actionInfo()
    {
        $canChange = !Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org])->p_status;
        return $this->render('info', compact('canChange'));
    }
    public function actionUserInfo($id_org){
        $models = UserInfo::findAll(['id_org'=>$id_org]);
        if ($post = Yii::$app->request->post()){

            $oldIds = ArrayHelper::map($models,'id','id');
            $models = UserInfo::createMultiple(UserInfo::className(), $models);
            UserInfo::loadMultiple($models, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIds, array_filter(ArrayHelper::map($models, 'id', 'id')));
            if (!empty($deletedIDs))
                UserInfo::deleteAll(['id' => $deletedIDs]);
            $save = true;
            foreach ($models as $model){
                $model->id_org = $id_org;
                $save &= $model->save();
            }

            if (isset($post['user_status'])) {
                $program = Program::findOne(['id_org' => $id_org]);
                $program->user_status = 1;
                $save &= $program->save();
            }

            return Json::encode(['success'=>$save]);
        }
        return $this->render('userInfo',compact('models'));
    }

    public function actionUpdate($id)
    {
        $model = OrgInfo::findOne(['id_org' => $id]);
        if ($model->load(Yii::$app->getRequest()->post()) and $model->save())
            return $this->redirect(['organization/info']);
        return $this->render('update', compact('model'));
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionListObject($id)
    {
        return $this->render('ListObject');
    }

    public function actionTableList($id)
    {
        $objects = ProgramObjects::find()->where(['id_org' => $id, 'system_status' => 1])->all();
        $countAll = 0;
        $vObr = 0;
        $recomend = 0;
        $notRecomend = 0;
        $naDorab = 0;

        $sved = [0,0,0,0];

        foreach($objects as $key => $object) {

            $countAll += 1;
            if($object->status == 1) {
                $vObr += 1;
            }
            if($object->status == 2) {
                $recomend += 1;
            }
            if($object->status == 3) {
                $notRecomend += 1;
            }
            if($object->status == 4) {
                $naDorab += 1;
            }


            foreach ($object->svedenia as $kek){
                if (!$object->type and $kek->is_nessesary and $object->status == 2)
                    $sved[0]++;
                if($object->type and $kek->is_nessesary and $object->status == 2)
                    $sved[1]++;
                if ($object->dep_status == 'approved')
                    $sved[2]++;
                if($object->dep_status == 'rejected')
                    $sved[3]++;
            }

            $objects[$key]['status'] = $object->astatus ? $object->astatus->label : '';
        }
        $programm = Program::find()->where(['id_org' => $id, 'system_status' => Program::ACTIVE])->one();

        return Json::encode([
            'objects' => $objects,
            'programm' => $programm,
            'organization'=>[
                'id'=>$programm->org->id,
                'name'=>$programm->org->name,
                'file'=>$programm->file_exist],
            'info' => [
                'countAll' => $countAll,
                'vObr' => $vObr,
                'recomend' => $recomend,
                'notRecomend' => $notRecomend,
                'naDorab' => $naDorab,
                'pr'=>$sved[0],
                'res'=>$sved[1],
                'dep'=>$sved[2],
                'depr'=>$sved[3],
                'st'=>(new ProgramStatus($id))->isDep() ? 'Рассмотрено' : 'Не рассмотрено'
            ]
        ]);
    }

    public function actionObjectView($id)
    {
        return $this->render('ObjectView');
    }

    public function commentPermision($obj_id)
    {
        $comment = Comments::find()->where(['id_user' => Yii::$app->user->id, 'id_obj' =>$obj_id])->one();
        if($comment) {
            return true;
        }

        return false;
    }

    public function actionSetApproveStatusDep($obj_id)
    {
        if(Yii::$app->getUser()->can('dep')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::APPROVE_STATUS;
            $object->save(false);
            new ProgramStatus(ProgramObjects::find()->where(['id' => $obj_id, 'system_status' => 1])->one()->id_org);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetRejectedStatusDep($obj_id)
    {
        if(Yii::$app->getUser()->can('dep')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::REJECTED_STATUS;
            $object->save(false);
            new ProgramStatus(ProgramObjects::find()->where(['id' => $obj_id, 'system_status' => 1])->one()->id_org);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetStatusDku($org_id)
    {
        if(Yii::$app->getUser()->can('dku')) {
            $post= Yii::$app->request->post();
            if (isset($post['dku_status'])) {
                $org = Organizations::find()->where(['id' => $org_id])->one();
                $org->dku_status = $post['dku_status'];
                $org->save(false);
            }
            if (isset($post['dku_atz'])) {
                $pr = Program::find()->where(['id_org' => $org_id])->one();
                $pr->dku_atz = $post['dku_atz'];
                $pr->save(false);
            }
            
            new ProgramStatus($org_id);
        }
    }
    public function actionSetCommentDku($org_id)
    {
        if(Yii::$app->getUser()->can('dku')) {
            $post= Yii::$app->request->post();
            if (isset($post['dku_comment'])) {
                $org = Organizations::findOne($org_id);
                $org->dku_comment = $post['dku_comment'];
                $org->save(false);
            }
        }
    }

    public function actionSetStatusDep($org_id)
    {
        if(Yii::$app->getUser()->can('dep')) {
            $status = Yii::$app->request->post('dep_status');
            $org = Organizations::find()->where(['id' => $org_id])->one();
            $org->dep_status = $status;
            $org->save(false);

            //new ProgramStatus($org_id);
        }
    }

    private function setStatus($obj_id, $status)
    {

        if(Yii::$app->getUser()->can('mgsu') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->status = $status;
            $object->save(false);
            return true;
        }
        return false;
    }

    public function actionGetApproveStatus($obj_id)
    {
        $query = ProgramObjects::findOne($obj_id);

        return json_encode([
            'label' => $query->astatus? $query->astatus->label : '',
            'id' => $query->astatus? $query->astatus->id : 0,
            'dep_status' => $query->dep_status,
            'dku_status' => $query->org->dku_status,
            'real_status'=> $query->real_status ?? 0,
        ]);
    }

}
