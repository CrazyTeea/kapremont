<?php

namespace app\controllers\api;

use app\models\User;
use Yii;
use yii\web\Controller;

class PermissionController extends Controller
{
    public function actionPermissions()
    {
        $user_id = Yii::$app->user->id;
        $permission = key(User::getRole($user_id));

        return json_encode($permission);
    }
}