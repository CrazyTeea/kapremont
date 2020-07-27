<?php

namespace app\controllers\api;

use app\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\UrlRuleInterface;

class CommentController extends ActiveController implements UrlRuleInterface
{
    public $modelClass = Comments::class;

    // public function actions()
    // {
    //     $actions = parent::actions();
    //     $actions['view']['run'] = [$this, 'query', 'id'];

    //     return $actions;
    // }

    // public function query()
    // {
    //     return Yii::createObject([
    //         'class' => ActiveDataProvider::class,
    //         'query' => $this->modelClass::find(),
    //     ]);
    // }


    public function actionObj($id)
    {
        return $this->modelClass::find()->where(['id_obj' => $id])->all();
    }

    public function actionUser()
    {
        return Yii::$app->user->id;
    }

    public function createUrl($manager, $route, $params)
    {
    }

    public function parseRequest($manager, $request)
    {
    }
}