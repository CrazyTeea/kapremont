<?php

namespace app\controllers\rest;

use app\models\FileComment;
use yii\web\Controller;
use app\models\UploadForm;
use app\models\User;
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
        if (file_exists($path))
            return Yii::$app->response->sendFile($path)->send();
        return 'файла не существует';
    }

    public function actionUploadAtz()
    {
        return 'here atz upload file';
        $post = Yii::$app->request->post();
        $id_atz = $post['id_atz'];
        $id_comment = $post['id_comment'];

        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        $saveFileComment = function () use ($upload, $id_atz, $id_comment) {
            $fileComment = new FileComment();
            $fileComment->id_atz = $id_atz;
            $fileComment->id_comment = $id_comment;
            $fileComment->file_name = $upload->file->basename;
            $fileComment->file_ext = $upload->file->extension;
            if($fileComment->save()) {
                return $fileComment->id;
            } else {
                return false;
            }
        };

        if($file_id = $saveFileComment()) {
            $path = 'uploads/comments/atz/' . $id_atz . '_' . $file_id;
            if (!file_exists($path))
                FileHelper::createDirectory($path);
            $upload->file->saveAs("$path/{$upload->file->name}");
            return true;
        }

        return false;
    }

    public function actionTest()
    {// Url::rest/upload/test

        echo "<pre>";
        print_r(array_unique($orgIds));
    }
}