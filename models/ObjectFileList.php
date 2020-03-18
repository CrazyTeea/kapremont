<?php

namespace app\models;

use Yii;

class ObjectFileList extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'object_file_list';
    }

    public function rules()
    {
        return [
            [['obj_id', 'file_id', 'descriptor'], 'required'],
            [['obj_id', 'file_id'], 'integer'],
        ];
    }
    
    public function attribute()
    {
        return [
            'id',
            'obj_id',
            'file_id',
            'descriptor',
        ];
    }
}
