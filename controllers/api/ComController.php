<?php

namespace app\controllers\api;

use app\models\Comments;
use app\models\FileComment;
use app\models\User;
use Yii;
use yii\web\Controller;

class ComController extends Controller
{
    public function actionGetComments($id_obj)
    {
        $comments = Comments::find()->where(['id_obj' => $id_obj])->all();
        $responce=[];
        foreach($comments as $comment) {

            $responce [] = [
                'id' => $comment->id,
                'message' => $comment->message,
                'id_user' => $comment->id_user,
                'username' => $comment->user->username,
                'created_at' => $comment->created_at,
                'user_role' => User::getRole($comment->id_user),
                'files' => FileComment::find()->select('id, id_obj, file_name, file_ext, archived')->where(['id_comment' => $comment->id])->asArray()->all()
            ];
        }

        return json_encode($responce);
    }

    public function actionSaveComment()
    {
        $post = (object) Yii::$app->request->post();

        $comment = new Comments();
        $comment->id_obj = $post->id_obj;
        $comment->message = $post->message;
        $comment->id_user = $post->id_user;
        $comment->user_role = User::getRole($comment->id_user);
        if($comment->save()) {
            return json_encode($comment->id);
        }

        return false;
    }

    public function actionDeleteComment($id_comment)
    {
        $fileComments = FileComment::find()->where(['id_comment' => $id_comment])->all();
        if(!empty($fileComments)) {
            foreach($fileComments as $fileComment) {
                $path ="uploads/comments/{$fileComment->id_obj}_{$fileComment->id}/{$fileComment->file_name}.{$fileComment->file_ext}";
                if (file_exists($path))
                    unlink($path);
                $fileComment->delete();
            }
        }
        $comment = Comments::findOne($id_comment);
        $comment->delete();
    }
}