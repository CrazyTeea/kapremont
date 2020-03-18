<?php

namespace app\controllers\app;

use app\models\Organizations;
use Yii;
use yii\web\Controller;

class MgsuAdminController extends Controller
{
    public function actionView()
    {
        return $this->render('index');
    }

    public function actionMainTable($offset)
    {
        $select = Organizations::getMainCheckTable($offset);
        
        return json_encode($select);
    }

    public function actionCount()
    {
        $count = Yii::$app->db->createCommand('SELECT count(*) as quantity FROM programm_mi.organizations')->queryAll();

        return json_encode($count);
    }
}
