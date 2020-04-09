<?php

namespace app\controllers\rest;

use app\models\FileComment;
use yii\web\Controller;
use app\models\UploadForm;
use Codeception\Command\Console;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public function actionUpload($id_obj, $id_comment)
    {
        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        if($file_id = $this->saveFileComment($upload, $id_obj, $id_comment)) {
            $upload->file->saveAs('uploads/comments/' . $id_obj . '_' . $file_id);
            return true;
        }

        return false;
    }

    private function saveFileComment(UploadForm $upload, $id_obj, $id_comment)
    {
        $fileComment = new FileComment();
        $fileComment->id_obj = $id_obj;
        $fileComment->id_comment = $id_comment;
        $fileComment->file_name = $upload->file->basename;
        $fileComment->file_ext = $upload->file->extension;
        if($fileComment->save()) {
            return $fileComment->id;
        } else {
            return false;
        }
    }

    public function actionDelete()
    {
        $upload = new UploadForm();
        $path = $this->path .  $upload->pdfFile->baseName . '.pdf';
        FileHelper::removeDirectory($path);
    }
}