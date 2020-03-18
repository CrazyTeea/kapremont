<?php


namespace app\controllers\app;


use Yii;

class ProgramController extends AppController
{
    public function actionIndex(){
        if (Yii::$app->user->can('orglist_view')){
            return $this->redirect(['/organization/list']);
        }
        return $this->render('index');
    }
}