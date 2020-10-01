<?php


namespace app\controllers\api;


use app\models\FileSAtzTableFive;
use app\models\UploadForm;
use yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

class FilesUploadController extends \yii\web\Controller
{
    public function actionSaveFile()
    {
        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        $post = Yii::$app->request->post();
        $id_atz = Yii::$app->request->post('id_atz');

        $base_path = "uploads/atz_five/$id_atz";

        $files_atz_table_five = new FileSAtzTableFive();
        $files_atz_table_five->id_atz = $post['id_atz'];
        $files_atz_table_five->id_card = $post['id_card'];
        $files_atz_table_five->file_name = $upload->file->baseName . '.' . $upload->file->extension;
        $files_atz_table_five->description = trim($post['description']);
        $files_atz_table_five->path = $base_path;

        if ($files_atz_table_five->save()) {
            if (!file_exists("$base_path")) {
                FileHelper::createDirectory($base_path);
            }
            $upload->file->saveAs("$base_path/$files_atz_table_five->id");
        }
    }

    public function actionGetInfo()
    {
        $post = Yii::$app->request->post();

        $files_atz_table_five = FileSAtzTableFive::find()->where(['id_atz' => $post['id_atz'], 'id_card' => $post['id_card']])->asArray()->all();

        return json_encode(ArrayHelper::map($files_atz_table_five, 'id', 'file_name', 'description'));
    }

    public function actionGetFile()
    {
        $id = Yii::$app->request->get('id');

        $file_atz_table_five = FileSAtzTableFive::findOne($id);

        $path = "$file_atz_table_five->path/$file_atz_table_five->id";

        if(file_exists($path)) {
            return Yii::$app->response->sendFile($path, $file_atz_table_five->file_name)->send();
        }

        return 'Файла не существует';
    }

    public function actionDeleteFile()
    {
        $id = Yii::$app->request->post('id');
        $file_atz_table_five = FileSAtzTableFive::findOne($id);
        $path = "$file_atz_table_five->path/$file_atz_table_five->id";
        if($file_atz_table_five->delete() && $path) {
            unlink($path);
        }
    }
}
