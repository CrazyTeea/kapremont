<?php


namespace app\controllers\api;

use app\models\UploadForm;
use app\models\User;
use yii\helpers\FileHelper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class FileMainPageController extends Controller
{
    public function actionGetFile()
    {
        $id_org = User::find()->where(['id' => Yii::$app->user->id])->one()->id_org ?? null;

        if (!isset($id_org))
            throw new \Exception('файл не найден');

        $file_names = FileHelper::findFiles(Yii::getAlias('@webroot') . '/static/downloads');
        foreach ($file_names as $file_name) {
            $files[] = substr($file_name, 70);
        }
        $file_needed = array_filter($files, function ($file) use ($id_org) {
            $id_org_file = explode('_', $file)[0];
            return $id_org_file == $id_org;
        });
        if (empty(array_keys($file_needed)))
            throw new \Exception('файл не найден');

        $full_path = 'static/downloads/' . $file_needed[array_keys($file_needed)[0]];
//        echo "<pre>";
//        print_r($file_needed);
//        if(file_exists($full_path)) return 'yes';

        return Yii::$app->response->sendFile($full_path);
    }

    public function actionSaveFile()
    {

        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        $type = Yii::$app->request->post('type');
        $id_org = User::find()->where(['id' => Yii::$app->user->id])->one()->id_org ?? null;

        if (!isset($id_org))
            throw new \Exception('файл нельзя созранить');

        $path = "uploads/mainAtz/$id_org";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $upload->file->saveAs("$path/$type");
    }
}