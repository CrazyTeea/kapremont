<?php

namespace app\models;

use yii\db\ActiveRecord;

class FaivUsers extends ActiveRecord
{
    public static function tableName()
    {
        return 'faiv_users';
    }

    public function rules()
    {
        return [
            [['id_user', 'id_founder'], 'required'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id_user' => 'id']);
    }

    public function getFounder()
    {
        return $this->hasOne(Founders::class, ['id_founder' => 'id']);
    }
}