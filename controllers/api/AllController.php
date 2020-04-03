<?php

namespace app\controllers\api;

use Yii;
use yii\web\Controller;

class AllController extends Controller
{
    public function actionTableList($id)
    {
        $query = Yii::$app->db->createCommand("SELECT 
                po.id_priority,
                cities.city,
                po.type
                po.regulation,
                po.assignment,
                po.square,
                po.address,
                po.year,
                po.wear,
                po.status
            FROM
                program_objects AS po
                    JOIN
                cities ON cities.id = po.id_city
            WHERE
                po.id_org = $id 
            AND po.status <> 0")->queryAll();

        return json_encode($query);
    }
}