<?php


namespace app\controllers\api;


use app\models\UploadForm;
use yii\web\UploadedFile;
use yii;

class FilesUploadController extends \yii\web\Controller
{
    public function actionSaveFile()
    {
        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        $id_atz = Yii::$app->request->post('id_atz');
        $id_card = Yii::$app->request->post('id_card');
        $description = Yii::$app->request->post('description');

        echo "<pre>";
        print_r($upload->file);

    }
}