<?php

namespace app\controllers\rest;

use Yii;
use yii\rest\Controller;

abstract class RestController extends Controller
{
    protected static $cans;
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->getUser()->getIsGuest()){
           Yii::$app->getSession()->set('cans',[
                Yii::$app->getUser()->can('root'),
                Yii::$app->getUser()->can('admin'),
                Yii::$app->getUser()->can('mon'),
                Yii::$app->getUser()->can('user'),
                Yii::$app->getUser()->can('root') || Yii::$app->getUser()->can('admin'),
            ]);
           self::$cans = Yii::$app->getSession()->get('cans');
        }
    }
}