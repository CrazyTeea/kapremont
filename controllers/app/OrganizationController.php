<?php


namespace app\controllers\app;

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
        $objects = ProgramObjects::find()->select('id, type, id_priority, name, finance_sum, coFinancing, status, dep_status')->where(['id_org' => $id, 'system_status' => 1])->all();
        $countAll = 0;
        $vObr = 0;
        $recomend = 0;
        $notRecomend = 0;
        $naDorab = 0;
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

            $objects[$key]['status'] = $object->astatus->label;
        }
        $programm = Program::find()->select(['finance_volume', 'finance_events', 'cost'])->where(['id_org' => $id, 'system_status' => Program::ACTIVE])->one();

        return Json::encode([
            'objects' => $objects,
            'programm' => $programm,
            'info' => [ 
                'countAll' => $countAll,
                'vObr' => $vObr, 
                'recomend' => $recomend,
                'notRecomend' => $notRecomend,
                'naDorab' => $naDorab
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

    public function actionSetRecomendStatus($obj_id)
    {
        $this->setStatus($obj_id, ApproveStatus::STATUS_RECOMEND);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetNotRecomendStatus($obj_id)
    {
        $this->setStatus($obj_id, ApproveStatus::STATUS_NOT_RECOMEND);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetToWorkStatus($obj_id)
    {
        $this->setStatus($obj_id, ApproveStatus::STATUS_TO_WORK);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetApproveStatusDep($obj_id)
    {
        if(Yii::$app->getUser()->can('dep') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::APPROVE_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetRejectedStatusDep($obj_id)
    {
        if(Yii::$app->getUser()->can('dep') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::REJECTED_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetApproveStatusDku($obj_id)
    {
        if(Yii::$app->getUser()->can('dku') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dku_status = ProgramObjects::APPROVE_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetRejectedStatusDku($obj_id)
    {
        if(Yii::$app->getUser()->can('dku') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dku_status = ProgramObjects::REJECTED_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    private function setStatus($obj_id, $status)
    {
        
        if(Yii::$app->getUser()->can('mgsu') && $this->commentPermision($obj_id)) {
            $object = ProgramObjects::findOne($obj_id);
            $object->status = $status;
            $object->save(false);
            return true;
        }
    }

    public function actionGetApproveStatus($obj_id)
    {
        $query = ProgramObjects::findOne($obj_id);

        return json_encode([
            'label' => $query->astatus->label,
            'id' => $query->astatus->id,
            'dep_status' => $query->dep_status,
            'dku_status' => $query->dku_status
        ]);
    }

}
