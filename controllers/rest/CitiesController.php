<?php


namespace app\controllers\rest;


use app\models\Cities;
use Yii;
use yii\helpers\Json;

class CitiesController extends RestController
{
    public function actionById(){
        if ($data = Yii::$app->getRequest()->getQueryParams()) {
            $data = (object)$data;
            return Cities::findAll(['id_region' => $data->id]) ? :[''];
        }
    }
}