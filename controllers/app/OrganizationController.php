<?php


namespace app\controllers\app;


use app\models\Organizations;
use app\models\OrgInfo;
use Yii;
use yii\helpers\Json;

class OrganizationController extends AppController
{
    public function actionInfo()
    {
        return $this->render('info');
    }

    public function actionUpdate($id)
    {
        $model = OrgInfo::findOne(['id_org'=>$id]);
        if ($model->load(Yii::$app->getRequest()->post()) and $model->save())
            return $this->redirect(['organization/info']);
        return $this->render('update',compact('model'));
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
        $query = Yii::$app->db->createCommand("SELECT 
                po.id,
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

        return Json::encode($query);
    }
}