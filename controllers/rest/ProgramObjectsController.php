<?php


namespace app\controllers\rest;


use app\models\ProgramObjects;
use yii\helpers\Json;

class ProgramObjectsController extends RestController
{
    public function actionById($id){
        if ($id) {
            $model = ProgramObjects::findOne($id);
            return Json::encode([
                'object' =>$model,
                'svedenia'=>$model->svedenia,
                'necessary'=>$model->necessary,
                'waited'=>$model->waites,
                'risks'=>$model->risks
            ]);
        }
        return null;
    }
}