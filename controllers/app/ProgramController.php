<?php


namespace app\controllers\app;


class ProgramController extends AppController
{
    public function actionIndex(){
        return $this->render('index');
    }
}