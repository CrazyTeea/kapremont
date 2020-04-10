<?php

namespace app\controllers\rest;

use app\models\FileComment;
use yii\web\Controller;
use app\models\UploadForm;
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
            $path = 'uploads/comments/' . $id_obj . '_' . $file_id;
            if (!file_exists($path))
                FileHelper::createDirectory($path);
            $upload->file->saveAs("$path/{$upload->file->name}");
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

    public function actionDownload($name)
    {
        $fileName = Yii::$app->request->get('fileName');
        $path= "uploads/comments/$name/$fileName";
        return Yii::$app->response->sendFile($path)->send();
    }

    public function actionTest()
    {// Url::rest/upload/test
        //
    }
}