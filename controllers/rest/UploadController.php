<?php

namespace app\controllers\rest;

use yii\web\Controller;
use app\models\UploadForm;
use Yii;
use yii\web\UploadedFile;

class UploadController extends Controller
{

    public function actionUpload()
    {
        $upload = new UploadForm();

        // echo "<pre>";
        // var_export($_FILES['pdfFile']);
        $upload->load($_FILES['pdfFile']);
        $upload->pdfFile = UploadedFile::getInstance($upload, 'pdfFile');
        $upload->save();
        if($upload->upload()) {
            return json_encode('vseOk');
        }
    }
}