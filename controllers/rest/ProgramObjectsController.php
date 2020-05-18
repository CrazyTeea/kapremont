<?php


namespace app\controllers\rest;


use app\models\ProgramObjects;
use yii\helpers\ArrayHelper;
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
            $svedenia = $svedenia2 = [];
            foreach ($model->svedenia as $s){
                $s->file_name = $s->file ? $s->file->file_name : 'f';
                $svedenia[] = ['model'=>$s,
                    'file'=>$s->file ? $s->file->file_name : null
                ];
            }
            foreach ($model->svedenia2 as $s){
                $s->file_name = $s->file ? $s->file->file_name : 'd';
                $svedenia2[] = ['model'=>$s,
                    'file'=>$s->file ? $s->file->file_name : null
                ];
            }

            return Json::encode([
                'object' =>$model,
                'organization'=>$model->org,
                'svedenia'=>$svedenia,
                'svedenia2'=>$svedenia2,
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