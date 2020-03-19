<?php

namespace app\controllers\app;

use app\models\Organizations;
use Yii;
use yii\helpers\Json;
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

        return Json::encode($select);
    }

    public function actionCount()
    {
        //$count = ['quantity' => Organizations::find()->from('organizations o')->join('join','program p',['o.id'=>'p.id_org'])->count('o.id')];
        $count = Yii::$app->db->createCommand('
        SELECT 
                    COUNT(res.id) as quantity
                FROM
                    (SELECT 
                        org.id, org.name, COUNT(po.id_org) AS quantity, reg.region
                    FROM
                        organizations AS org
                    JOIN regions AS reg ON org.id_region = reg.id
                    JOIN program_objects po ON org.id = po.id_org
                    WHERE
                        org.system_status = 1
                    GROUP BY po.id_org
                    ) AS res
                        JOIN
                    program pr ON pr.id_org = res.id
                ORDER BY res.id
        ')->queryOne();

        return Json::encode($count);
    }
}
