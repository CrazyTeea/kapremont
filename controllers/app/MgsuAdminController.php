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

    public function actionObjectsTable($offset)
    {
        $post = Json::decode(Yii::$app->request->post('form'));
        $select = ProgramObjects::find()->where(['system_status'=>1,'status'=>$post['status']])->offset($offset)->limit(10)->all();
        $count = ProgramObjects::find()->where(['system_status'=>1,'status'=>$post['status']])->count();

        $toServ = [];
        foreach ($select as $i=> $item){
            $toServ[$i] = [
              'o_id'=>$item->org->id,
              'o_name'=>$item->org->name,
                'po_id'=>$item->id,
                'priority'=>$item->type,
                'type'=>$item->id_priority,
                'po_name'=>$item->name
            ];
        }

        return Json::encode([
            'items'=>$toServ,
            'count'=>$count]);
    }

    public function getParamsObjects($request)
    {
        $where_clouse = '';

        $param_status = [
            'status' => $request->status ?? null,
        ];

        foreach($param_status as $key => $param) {
            if($param) {
                $where_clouse .= " and $key = $param";
            }
        }
        
        return $where_clouse;
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
