<?php

namespace app\models;

use app\models\User;
use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['id_user', 'id_obj', 'message'], 'required']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'id_obj',
            'message',
            'id_user',
            'username' => function($model) {return $model->user->username;},
            'created_at',
            'user_role' => function($model){return User::getRole($model->id_user);}
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}