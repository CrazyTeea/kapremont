<?php


namespace app\controllers\app;


use app\facades\ProgramStatus;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class ProgramController extends AppController
{
    public function actionIndex(){
        $user = User::findOne(Yii::$app->user->id);
        if ($user->username == 'admin@admin.ru' or
            $user->username == 'kozlov_v@mirea.ru' or
            Yii::$app->user->can('orglist_view') or
            Yii::$app->user->can('faiv_admin')){
            return $this->redirect(['/organization/list']);
        }
        return $this->render('index');
    }

    public function actionIsApprove($id_org = 0){

        $id = $id_org ? : Yii::$app->session->get('user')->id_org;



        $gg = Program::findOne(['id_org'=>$id]);


        return Json::encode($gg);
    }

    public function actionExport($type){
        $objs = Program::findAll(['system_status'=>1]);
        $param = 'export';
        if ($type==2)
            $param = 'export2';

        $html = $this->renderPartial("_$param",compact('objs'));
        $reader = new HTML();
        $spreadsheet = $reader->loadFromString($html);
        $writer = IOFactory::createWriter($spreadsheet,'Xls');

        $path = Yii::getAlias( '@webroot' ) . "/uploads/$param";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $writer->save("$path/$param.xls");
        Yii::$app->response->sendFile("$path/$param.xls")->send();
        if (file_exists("$path/$param.xls"))
            unlink("$path/$param.xls");
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
                $status = new ProgramStatus($program->id_org);

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