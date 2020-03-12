<?php

namespace app\controllers\app;

use app\models\User;
use Yii;

class AppController extends \yii\web\Controller
{
   public static $cans;

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
            }
            self::$cans = Yii::$app->getSession()->get('cans');
            Yii::$app->getSession()->set('user',User::findOne(Yii::$app->user->id));
        }
}