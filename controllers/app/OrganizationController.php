<?php


namespace app\controllers\app;


use Yii;

class OrganizationController extends AppController
{
    public function actionInfo(){
        return $this->render('info');
    }
}