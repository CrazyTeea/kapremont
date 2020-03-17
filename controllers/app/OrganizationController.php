<?php


namespace app\controllers\app;


use app\models\Organizations;
use app\models\OrgInfo;
use Yii;

class OrganizationController extends AppController
{
    public function actionInfo(){
        return $this->render('info');
    }
    public function actionUpdate($id){
        $model = OrgInfo::findOne(['id_org'=>$id]);
        if ($model->load(Yii::$app->getRequest()->post()) and $model->save())
            return $this->redirect(['organization/info']);
        return $this->render('update',compact('model'));
    }
}