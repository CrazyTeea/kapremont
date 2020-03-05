<?php

namespace app\controllers\rest;

use yii\rest\ActiveController;
use app\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends ActiveController
{
    public $modelClass = UploadForm::class;

    public function actionUpload()
    {
        $upload = new UploadForm();
        $upload->pdfFile = UploadedFile::getInstance($upload, 'pdfFile');
        if($upload->upload()) {
            return;
        }
    }
}