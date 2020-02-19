<?php

namespace app\controllers\app;

class TestController extends AppController
{
    public function actionIndex(){
        $kek = "sdfksdfjsd    sdkjfskd ";
        var_dump($kek);
        var_dump(preg_replace('/\s/', '', $kek));
        return 'fd';
    }
}