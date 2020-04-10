<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\Comments;
use app\models\FaivUsers;
use app\models\Founders;
use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
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

        if(Yii::$app->user->can('faiv_admin')) {
            $id_founder = FaivUsers::find()->where(['id_user' => Yii::$app->user->id])->one()->id_founder;
            $params = $this->getParams(json_decode(Yii::$app->request->post('form')));
            $order = $this->getOrder(json_decode(Yii::$app->request->post('form')));
            $select = Organizations::getMainCheckTable($offset, $params, $order, " and id_founder = $id_founder");
            $count = Organizations::getMainCheckTableCount($params, " and id_founder = $id_founder");

            return Json::encode([
                'rows' => $select,
                'count' => $count
            ]);
        }

        $params = $this->getParams(json_decode(Yii::$app->request->post('form')));
        $order = $this->getOrder(json_decode(Yii::$app->request->post('form')));
        $select = Organizations::getMainCheckTable($offset, $params, $order);
        $count = Organizations::getMainCheckTableCount($params);

        return Json::encode([
            'rows' => $select,
            'count' => $count
        ]);
    }

    public function actionObjectsTable($offset)
    {
        $post = Json::decode(Yii::$app->request->post('form'));
        $post_close = $this->getParamsObjects($post);

        // echo "<pre>";
        // print_r($params);
        $static_clause=[
            'system_status' => 1,
        ];

        $begin_clause = [
            'status' => $post['status'],
        ];

        if (!isset($post['or_where'])) {
            if (isset($post['dep_status']))
                $begin_clause['dep_status'] = $post['dep_status'];
            if (isset($post['dku_status']))
                $begin_clause['dku_status'] = $post['dku_status'];
        }
        $params = array_merge($begin_clause, $post_close ?? [] );

        $select = ProgramObjects::find()->where($static_clause)->andWhere($params)->andWhere(['<>','status',0])->offset($offset)->limit(10);
        $count = ProgramObjects::find()->where($static_clause)->andWhere($params)->andWhere(['<>','status',0]);
        if (isset($post['or_where'])){
            $select->andWhere(['or',['dep_status'=>$post['dep_status']],['dku_status'=>$post['dku_status']]]);
            $count->andWhere(['or',['dep_status'=>$post['dep_status']],['dku_status'=>$post['dku_status']]]);
        }
        $select = $select->all();
        $count = $count->count();



        $toServ = [];
        foreach ($select as $i => $item) {
            $toServ[$i] = [
                'o_id' => $item->org->id,
                'o_name' => $item->org->name,
                'po_id' => $item->id,
                'priority' => $item->type,
                'type' => $item->id_priority,
                'po_name' => $item->name,
                'last_comment_role' => $item->lastcomment ? $item->lastcomment->user_role : null
            ];
        }

        return Json::encode([
            'items' => $toServ,
            'count' => $count
        ]);
    }

    public function getParamsObjects($request)
    {
        $param_status = [
            'id_org' => $request['id_org'] ?? null,
            'id' => $request['id'] ?? null,
        ];

        foreach ($param_status as $key => $param) {
            if ($param != null) {
                $where_clause[$key] = $param;
            }
        }

        return $where_clause ?? null;
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
            if ($param) {
                $where_clouse .= " and res.$key like '$param%'";
            }
        }

        foreach ($params2 as $key => $param) {
            if ($param != null) {
                $where_files .= " and pr.$key = $param";
            }
        }

        foreach ($regParams as $key => $param) {
            if ($param != null) {
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
            if ($param === 'up') {
                $order = 'res.quantity';
            } elseif ($param === 'down') {
                $order = 'res.quantity desc';
            }
        }

        return $order ?? $default;
    }
}
