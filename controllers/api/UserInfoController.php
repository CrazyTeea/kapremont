<?php


namespace app\controllers\api;


use app\models\UserInfo;
use app\models\UserInfoRoles;
use yii\helpers\Json;
use yii\web\Controller;

class UserInfoController extends Controller
{
    public function actionRoles()
    {
        $roles = UserInfoRoles::find()->all();
        return Json::encode($roles);
    }

    public function actionUsers($id_org)
    {
        $users = UserInfo::findAll(['id_org' => $id_org]);
        $toServ = [];
        foreach ($users as $user) {
            $toServ[] = [
                'name' => $user->name,
                'role' => $user->userRole->role,
                'position' => $user->position,
                'phone' => $user->phone,
                'email' => $user->email
            ];
        }
        return Json::encode($toServ);
    }
}