<?php

namespace app\controllers\app;

class TestController extends AppController
{
    public function actionIndex()
    {
        $a = getenv('DB_SCHEMA');
        return $a;
        //sdgsdgsfg
    }
}