<?php

namespace app\controllers\app;

use yii\web\Controller;

class AtzController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}