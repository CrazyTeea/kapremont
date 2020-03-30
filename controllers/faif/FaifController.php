<?php

namespace app\controllers\faif;

use yii\web\Controller;

class FaifController extends Controller
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