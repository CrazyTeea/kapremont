<?php

namespace app\controllers\rest;

use yii\web\Controller;
use app\models\UploadForm;
use Codeception\Command\Console;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    private $path = 'uploads/';

    public function actionUpload()
    {
        $upload = new UploadForm();
        $upload->pdfFile = UploadedFile::getInstanceByName('pdfFile');
        $upload->pdfFile->saveAs($this->path . $upload->pdfFile->baseName . '.pdf');
    }

    public function actionDelete()
    {
        $upload = new UploadForm();
        $path = $this->path .  $upload->pdfFile->baseName . '.pdf';
        FileHelper::removeDirectory($path);
    }
}