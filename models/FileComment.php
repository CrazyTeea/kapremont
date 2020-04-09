<?php

namespace app\models;

use yii\db\ActiveRecord;

class FileComment extends ActiveRecord
{
    public static function tableName()
    {
        return 'file_comments';
    }

    public function rules()
    {
        return [
            [['id_obj', 'file_name', 'file_ext'], 'required'],
            [['archived'], 'default', 'value' => false]
        ];
    }
}