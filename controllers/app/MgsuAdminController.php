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
        $params = $this->getParams(json_decode(Yii::$app->request->post('form')));
        $select = Organizations::getMainCheckTable($offset, $params);
        $count = Organizations::getMainCheckTableCount($params);

        return Json::encode([
            'rows' => $select,
            'count' => $count
        ]);
    }

    private function getParams($request) //даже не смотри сюда, тут говнокод
    {
        $where_clouse = '';
        $where_files = '';
        $params1 =  [
            'id' => $request->id ?? null,
            'region' => $request->region ?? null,
            'organization' => $request->organization ?? null,

        ];

        $params2 = [
            'file_exist' => $request->file_exist ?? null,
            'status' => $request->status ?? null,
        ];

        $params3 = [
            'quantity' => $request->quantity ?? null,
        ];

        foreach ($params1 as $key => $param) {
            if($param) {
                $where_clouse .= " and res.$key like '$param%'";
            }
        }

        foreach ($params2 as $key => $param) { 
            if($param != null) {
                $where_files .= " and pr.$key = $param";
            }
        }

        return $where_clouse . $where_files;
    }
}
