<?php

namespace app\controllers\faiv;

use yii\web\Controller;

class FaivController extends Controller
{
    public function actionUserView()
    {
        return $this->render('user');
    }

    public function actionUserCreateView()
    {
        return $this->render('userCreate');
    }

    public function actionAdminView()
    {
        return $this->render('admin');
    }
}