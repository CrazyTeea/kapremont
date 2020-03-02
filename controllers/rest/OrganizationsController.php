<?php


namespace app\controllers\rest;


use app\models\Organizations;
use app\models\User;
use Yii;
use yii\helpers\Json;

class OrganizationsController extends RestController
{
    public function actionByUsername(){
        if ($data = Yii::$app->getRequest()->getRawBody()){
            $data = (object)Json::decode($data);
            $user = User::find()->where(['username'=>$data->login])->one();
            return [
                "org" =>$user->organization,
            ];
        }
    }
    public function actionCurrent(){


            $user = Yii::$app->getSession()->get('user');
            return [
                "org" =>$user->organization,
            ];

    }
    public function actionById(){
        if ($data = Yii::$app->getRequest()->getRawBody()){
            $data = (object)Json::decode($data);
            $org = Organizations::findOne($data->id);
            if ($org)
                return [
                "org" =>$org,
                "region"=>$org->region
                ];
        }
    }
}