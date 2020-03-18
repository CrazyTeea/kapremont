<?php

namespace app\controllers\app;

use yii\web\Controller;

class MgsuAdminController extends Controller
{
    public function actionView()
    {
        $forTable = 'lol';

        return $this->render('index');
    }
}