<?php


namespace app\controllers\rest;


use app\models\ProgramObjects;
use yii\helpers\Json;

class ProgramObjectsController extends RestController
{
    public function actionById($id)
    {
        if ($id) {
            $model = ProgramObjects::findOne($id);
            $docs=[];
            foreach ($model->docList as $item){
                $docs[]=[
                    'name'=>$item->file->name,
                    'id'=>$item->file->id,
                    'label'=>$item->type->label
                ];
            }

            return Json::encode([
                'object' =>$model,
                'organization'=>$model->org,
                'svedenia'=>$model->svedenia,
                'svedenia2'=>$model->svedenia2,
                'necessary'=>$model->necessary,
                'program'=>$model->org->program,
                'waited'=>$model->waites,
                'risks'=>$model->risks,
                'docs'=>$docs,
                'org_id' => $model->id_org
            ]);
        }
        return null;
    }

    public function actionGetStatus($id)
    {
        $model = ProgramObjects::findOne($id);
        return Json::encode($model->status);
    }
}