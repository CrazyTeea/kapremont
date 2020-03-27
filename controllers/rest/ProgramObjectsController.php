<?php


namespace app\controllers\rest;


use app\models\ProgramObjects;
use yii\helpers\Json;

class ProgramObjectsController extends RestController
{
    public function actionById($id){
        if ($id) {
            $model = ProgramObjects::findOne($id);
            $docs=[];
            foreach ($model->docList as $item){
                $docs[]=[
                    'name'=>$item->file->name,
                    'id'=>$item->file->id
                ];
            }
            return Json::encode([
                'object' =>$model,
                'organization'=>$model->org,
                'svedenia'=>$model->svedenia,
                'necessary'=>$model->necessary,
                'waited'=>$model->waites,
                'risks'=>$model->risks,
                'docs'=>$docs
            ]);
        }
        return null;
    }
}