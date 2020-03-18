<?php


namespace app\controllers\app;


use app\models\Program;
use app\models\ProgramObjects;
use Yii;

class ProgramController extends AppController
{
    public function actionIndex(){
        if (Yii::$app->user->can('orglist_view')){
            return $this->redirect(['/organization/list']);
        }
        return $this->render('index');
    }

    public function actionApprove(){
        $program = Yii::$app->session->get('program');
        if (!$program)
            $program = Program::findOne(['id_org'=>Yii::$app->session->get('user')->id_org]);
        $program->status = 1;
        $objects = ProgramObjects::findAll(['system_status'=>1,'id_org'=>$program->id_org]);
        if ($objects) {
            foreach ($objects as $object){
                $object->status = 0;
            }
        }

    }
}