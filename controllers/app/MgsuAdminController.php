<?php

namespace app\controllers\app;

use app\models\Organizations;
use Yii;
use yii\web\Controller;

class MgsuAdminController extends Controller
{
    public function actionView()
    {

        // $zapr = Organizations::find()
        //     ->alias('org')
        //     ->select('org.id, org.name, org.id_region, reg.region, count(po.id_org) as count_org')
        //     ->innerJoin('region reg', 'org.id_region = reg.id')
        //     ->innerJoin('programObjects po', 'org.id = po.id_org')
        //     ->where(['org.system_status' => 1])
        //     ->groupBy('po.id_org')
        //     ->limit(10)
        //     ->asArray()
        //     ->all();
        // echo "<pre>";
        // print_r($select);

        return $this->render('index');
    }
    
    public function actionMainTable($offset)
    {
        $select = Yii::$app->db
            ->createCommand('SELECT 
                    `org`.`id`,
                    `org`.`name`,
                    `org`.`id_region`,
                    `reg`.`region`,
                    COUNT(po.id_org) AS `count_org`
                FROM
                    `organizations` `org`
                        inner JOIN
                    `regions` `reg` ON `org`.`id_region` = `reg`.`id`
                        inner JOIN
                    `program_objects` `po` ON `org`.`id` = `po`.`id_org`
                WHERE
                    `org`.`system_status` = 1
                GROUP BY `po`.`id_org`
                LIMIT 10
                OFFSET ' . $offset
                )
            ->queryAll();

        return json_encode($select);
    }

    public function actionCount()
    {
        $count = Yii::$app->db->createCommand('SELECT count(*) as quantity FROM programm_mi.organizations')->queryAll();
        
        return json_encode($count);
    }
}