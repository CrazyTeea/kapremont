<?php

namespace app\controllers\rest;

use app\models\User;
use Yii;
use yii\rest\Controller;

abstract class RestController extends Controller
{
    protected static $cans;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->getUser()->getIsGuest()) {
            Yii::$app->getSession()->set('cans', [
                Yii::$app->getUser()->can('root'),
                Yii::$app->getUser()->can('admin'),
                Yii::$app->getUser()->can('mon'),
                Yii::$app->getUser()->can('user'),
                Yii::$app->getUser()->can('root') || Yii::$app->getUser()->can('admin'),
                true
            ]);
            self::$cans = Yii::$app->getSession()->get('cans');
            Yii::$app->getSession()->set('user', User::findOne(Yii::$app->user->id));
            // Yii::$app->getSession()->set('id_org',User::findOne(Yii::$app->user->id)->id_org);
        }
    }
}