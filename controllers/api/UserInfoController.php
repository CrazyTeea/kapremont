<?php


namespace app\controllers\api;


use app\models\UserInfoRoles;
use yii\helpers\Json;
use yii\web\Controller;

class UserInfoController extends Controller
{
    public function actionRoles(){
        $roles = UserInfoRoles::find()->all();
        return Json::encode($roles);
    }
}