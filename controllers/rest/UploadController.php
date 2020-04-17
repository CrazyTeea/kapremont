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
        return Yii::$app->response->sendFile($path)->send();
    }

    public function actionTest()
    {// Url::rest/upload/test

        $rolesId = array_merge(User::getUsersByRole('faiv_admin'), User::getUsersByRole('faiv_user')) ;
        $users = User::find()->where(['in', 'id', $rolesId])->all();
        foreach($users as $user) {
            $orgIds[] = $user->id_org;
        }

        // $selects = User::find()
        //     ->joinWith(['organization' => function($query) {
        //         $query
        //             ->select('org.id, org.name, COUNT(po.id_org) as quantity, reg.region, org.dep_status, org.dku_status')
        //             ->alias('org')
        //             ->joinWith('region reg', true, 'JOIN')
        //             ->joinWith('programObjects po', true, 'JOIN')
        //             ->where(['org.id' => 104]);
        //     }], true, 'JOIN')
        //     ->where(['in', 'user.id', $rolesId])->all();
        
        // foreach($selects as $select) {
        //     $toServ[] = [
        //         'id' => $select->organization->id,
        //         'name' => $select->organization->name,
        //         'quantity' => $select->organization->quantity,
        //         'region' => $select->organization->region,
        //         'dep_status' => $select->organization->dep_status,
        //         'dku_status' => $select->organization->dku_status
        //     ];   
        // }

        echo "<pre>";
        print_r(array_unique($orgIds));
    }
}