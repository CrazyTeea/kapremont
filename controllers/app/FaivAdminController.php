<?php

namespace app\controllers\app;

use app\models\User;
use Yii;
use yii\web\Controller;
use app\facades\FilterBuilder;

class FaivAdminController extends Controller
{
    public function actionFaiv()
    {
        return $this->render('index');
    }

    public function actionGetUsers($offset = 0)
    {
        $params = $this->getFilters(json_decode(Yii::$app->request->post('filters')));
        $query = User::find()->where($params)->limit(10)->all();
        foreach ($query as $key => $user) {
            $responce[$key] = [
                'id' => $user->id,
                'username' => $user->username,
                'org' => $user->organization->name,
            ];
        }

        return json_encode($responce);
    }

    public function actionTest()
    {
        //http://localhost:3000/app/faiv-admin/test
        $request = (object) [
            'id' => 1,
            'username' => 'test'
        ];

        $filters = (new FilterBuilder($request))->whereLike('id')->get();
        // $query = User::find()->where($filters)->limit(10)->all();

        echo "<pre>";
        print_r($filters);

        $filt = $this->getFilters($request);
        // $query = User::find()->where($filt)->limit(10)->all();


        echo "<pre>";
        print_r($filt);
    }

    private function getFilters($request)
    {
        //['like', 'username', '%test%', false]
        $params = [
            'id' => $request->id ?? null,
            'username' => $request->username ?? null
        ];


        foreach ($params as $key => $param) {
            if($param != null) {
                $filters [] = "'like', $key, '%$param%', false";
            }
        }

        return $filters ?? [];
    }
}