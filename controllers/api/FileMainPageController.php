<?php


namespace app\controllers\api;

use app\models\MainAtzFileStatistics;
use app\models\Organizations;
use app\models\UploadForm;
use app\models\User;
use yii\helpers\FileHelper;
use yii\helpers\Json;
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
            $file_str_exploded = explode('/', $file_name);
            $count = count($file_str_exploded);
            $files[] = implode('/', [$file_str_exploded[$count - 2], $file_str_exploded[$count - 1]]);
        }

        $file_needed = array_filter($files, function ($file) use ($id_org) {
            $id_org_file = explode('_', $file)[0];
            return $id_org_file == $id_org;
        });
        if (empty(array_keys($file_needed)))
            throw new \Exception('файл не найден');
        $full_path = 'static/downloads/' . $file_needed[array_keys($file_needed)[0]];

        return Yii::$app->response->sendFile($full_path);
    }

    public function actionSaveFile()
    {

        $upload = new UploadForm();
        $upload->file = UploadedFile::getInstanceByName('file');
        $type = Yii::$app->request->post('type');
        $id_org = User::findOne(Yii::$app->user->id)->id_org ?? null;

        if (!isset($id_org))
            throw new \Exception('файл нельзя созранить');

        $path = "uploads/mainAtz/$id_org";
        if (!file_exists($path))
            FileHelper::createDirectory($path);

        $org = Organizations::findOne($id_org);

        $file_statistics = MainAtzFileStatistics::find()->where(['path' => "$path/{$org->name}.$type"])->one();

        if (is_null($file_statistics)) {
            $new_file_statistics = new MainAtzFileStatistics();
            $new_file_statistics->id_org = $org->id;
            $new_file_statistics->path = "$path/{$org->name}.$type";
            $new_file_statistics->save();
        }

        $upload->file->saveAs("$path/{$org->name}.$type");
    }

    public  function actionGetFileInfo()
    {
        $id_org = Yii::$app->request->post('id_org');

        $org = Organizations::findOne($id_org);

        $file_xlsx_path = "uploads/mainAtz/$id_org/{$org->name}.xlsx";
        $file_pdf_path = "uploads/mainAtz/$id_org/{$org->name}.pdf";

        return Json::encode([
            'xlsx' => file_exists($file_xlsx_path),
            'pdf' => file_exists($file_pdf_path),
        ]);
    }

    public function actionGetUploadedFile($id_org, $type)
    {
        $orgInfo = Organizations::findOne($id_org);
        $path = "uploads/mainAtz/$id_org/$orgInfo->name.$type";

        if (!file_exists($path))
            throw new \Exception('файл не найден');

        return Yii::$app->response->sendFile($path, "$id_org\_\\$orgInfo->name.$type");
    }

    public function actionHardResetMainAtzFileStatistics()
    {
        $directory = 'uploads/mainAtz';

        $files = FileHelper::findFiles($directory);

        $needed_files = array_map(function ($element) {
            $array = explode('/', $element);
            return [
                'id_org' => array_splice($array, 2, 1)[0],
                'path' => $element
            ];
        }, $files);

//        Yii::$app->db->createCommand('TRUNCATE TABLE main_atz_files_statistics')->execute();

        foreach($needed_files as $file_to_save) {
            $file_instance = new MainAtzFileStatistics();
            $file_instance->id_org = $file_to_save['id_org'];
            $file_instance->path = $file_to_save['path'];
            $file_instance->save();
        }

        echo "<pre>";
        print_r($needed_files);
    }
}