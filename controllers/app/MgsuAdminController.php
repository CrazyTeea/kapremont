<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;
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
        $order = $this->getOrder(json_decode(Yii::$app->request->post('form')));
        $select = Organizations::getMainCheckTable($offset, $params, $order);
        $count = Organizations::getMainCheckTableCount($params);
        // echo "<pre>";
        // print_r($order);

        return Json::encode([
            'rows' => $select,
            'count' => $count
        ]);
    }

    private function getParams($request) //даже не смотри сюда, тут говнокод
    {
        $where_clouse = '';
        $where_org_name = '';
        $where_files = '';
        $status_clouse = '';

        $params1 =  [
            'id' => $request->id ?? null,
            'status' => $request->status ?? null,
        ];

        $regParams = [
            'name' => $request->name ?? null,
            'region' => $request->region ?? null,
        ];

        $params2 = [
            'file_exist' => $request->file_exist ?? null,
            'p_status' => $request->p_status ?? null,
          
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

        foreach ($regParams as $key => $param) {
            if($param != null) {
                $where_org_name .= " and res.$key like '%$param%'";
            }
        }

        return $where_clouse . $where_files . $where_org_name . $status_clouse;
    }

    private function getOrder($request, $default = 'res.id')
    {
        $params =  [
            'order' => $request->quantity ?? null,
        ];
        
        foreach ($params as $param) {
            if($param === 'up') {
                $order = 'res.quantity';
            } elseif($param === 'down') {
                $order = 'res.quantity desc';
            }
        }

        return $order ?? $default;
    }
}
