<?php


namespace app\controllers\rest;


use app\models\User;
use Yii;
use yii\helpers\Json;

class SystemController extends RestController
{
    public function actionGetUser(){
        if ($data = Yii::$app->getRequest()->getRawBody()){
            $data = (object)Json::decode($data);
            $user = User::find()->where(['username'=>$data->login])->one();
            return [
                'organization'=>$user->organization,
                'fio'=>$user->fio,
                'position'=>$user->position,
                'isAdmin'=> self::$cans[4]
            ];
        }
    }
}