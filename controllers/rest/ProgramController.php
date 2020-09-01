<?php


namespace app\controllers\rest;


use app\models\Program;
use app\models\User;
use Yii;
use yii\helpers\Json;

class ProgramController extends RestController
{
    public function actionGetByIdOrg()
    {
        if ($data = Yii::$app->getRequest()->getRawBody()) {
            $data = (object)Json::decode($data);
            $program = Program::findOne(['system_status' => 1, 'id_org' => $data->id_org]);
            return [
                "program" => $program,
            ];
        }
    }
}