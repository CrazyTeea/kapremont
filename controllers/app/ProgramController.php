<?php


namespace app\controllers\app;


use app\models\Program;
use app\models\ProgramObjects;
use Yii;
use yii\helpers\Json;

class ProgramController extends AppController
{
    public function actionIndex(){
        if (Yii::$app->user->can('orglist_view')){
            return $this->redirect(['/organization/list']);
        }
        return $this->render('index');
    }
    public function actionIsApprove(){
        $program = Yii::$app->session->get('program');
        if (!$program)
            $program = Program::find()->where(['id_org' => Yii::$app->session->get('user')->id_org])->one();

        $id_org = Yii::$app->session->get('user')->id_org;

        $gg = Yii::$app->db->createCommand("SELECT p_status FROM program where id_org = {$id_org} ")->queryOne();


        return Json::encode($gg);
    }

    public function actionApprove(){
        if (Yii::$app->request->isPost) {
            $program = Yii::$app->session->get('program');
            $errrMsg = 'Что то пошло не так, звоните фиксикам';
            $status = false;
            $id_org = Yii::$app->session->get('user')->id_org;
            if (!$program)
                $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
            if ($program->file_exist) {
                $gg = Yii::$app->db->createCommand("UPDATE program set p_status = 1 where id_org = {$id_org} ")->execute();
            } else  $errrMsg = 'Файл должен быть загружен';
            $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
            return Json::encode(['programStatus'=>$program->p_status,'status' => $status, 'msg' => $errrMsg]);
        }

        /*$objects = ProgramObjects::findAll(['system_status'=>1,'id_org'=>$program->id_org]);
        if ($objects) {
            foreach ($objects as $object){
                $object->status = 0;
                $object->save(false);
            }
        }*/
    }
}