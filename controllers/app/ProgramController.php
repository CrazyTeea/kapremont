<?php


namespace app\controllers\app;


use app\models\Program;
use app\models\ProgramObjects;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;
use yii\helpers\FileHelper;
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

        $id_org = Yii::$app->session->get('user')->id_org;

        $gg = Yii::$app->db->createCommand("SELECT p_status,ban,user_status FROM program where id_org = {$id_org} ")->queryOne();


        return Json::encode($gg);
    }

    public function actionExport(){
        $objs = Program::findAll(['system_status'=>1]);
        $html = $this->renderPartial('_export',compact('objs'));
        $reader = new HTML();
        $spreadsheet = $reader->loadFromString($html);
        $writer = IOFactory::createWriter($spreadsheet,'Xls');

        $path = Yii::getAlias( '@webroot' ) . "/uploads/export";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $writer->save("$path/export.xls");
        Yii::$app->response->sendFile("$path/export.xls")->send();
        if (file_exists("$path/export.xls"))
            unlink("$path/export.xls");
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
                Yii::$app->db->createCommand("UPDATE program set p_status = 1 where id_org = {$id_org} ")->execute();
                $status = true;
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