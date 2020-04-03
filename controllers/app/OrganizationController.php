<?php


namespace app\controllers\app;

use app\models\ApproveStatus;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
use Yii;
use yii\helpers\Json;

class OrganizationController extends AppController
{
    public function actionInfo()
    {
        $canChange = !Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org])->p_status;
        return $this->render('info', compact('canChange'));
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
        $query = Yii::$app->db->createCommand("
            SELECT 
                po.id,
                po.type,
                po.id_priority,
                cities.city,
                po.name,
                po.assignment,
                po.square_kap,
                po.address,
                po.year,
                po.wear,
                po.regulation,
                po.finance_sum,
                po.coFinancing,
                po.system_status
            FROM
                program_objects AS po
                    JOIN
                cities ON cities.id = po.id_city
            WHERE
                po.id_org = $id AND po.system_status = 1")->queryAll();

        $programm = Program::find()->select(['finance_volume', 'finance_events', 'cost'])->where(['id_org' => $id, 'system_status' => Program::ACTIVE])->one();
        return Json::encode([
            'objects' => $query,
            'programm' => $programm
        ]);
    }

    public function actionObjectView($id)
    {
        return $this->render('ObjectView');
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
        if(Yii::$app->getUser()->can('dep')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::APPROVE_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetRejectedStatusDep($obj_id)
    {
        if(Yii::$app->getUser()->can('dep')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dep_status = ProgramObjects::REJECTED_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetApproveStatusDku($obj_id)
    {
        if(Yii::$app->getUser()->can('dku')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dku_status = ProgramObjects::APPROVE_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetRejectedStatusDku($obj_id)
    {
        if(Yii::$app->getUser()->can('dku')) {
            $object = ProgramObjects::findOne($obj_id);
            $object->dku_status = ProgramObjects::REJECTED_STATUS;
            $object->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    private function setStatus($obj_id, $status)
    {
        if(Yii::$app->getUser()->can('mgsu')) {
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
