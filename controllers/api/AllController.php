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
                po.regulation,
                po.assignment,
                po.square,
                po.address,
                po.year,
                po.wear
            FROM
                program_objects AS po
                    JOIN
                cities ON cities.id = po.id_city
            WHERE
                po.id_org = $id")->queryAll();

        return json_encode($query);
    }
}