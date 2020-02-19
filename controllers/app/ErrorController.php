<?php


namespace app\controllers\app;


class ErrorController extends AppController
{
    public function actionBrowser(){
        return $this->render('browser');
    }
}