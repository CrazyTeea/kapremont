<?php


namespace app\controllers\rest;


class ProgramController extends RestController
{
    public function actionIndex(){
        return $this->render('index');
    }
}