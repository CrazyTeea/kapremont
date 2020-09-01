<?php

namespace app\models;

use yii\db\ActiveRecord;


/***
 * Class FileComment
 * @package app\models
 * @property string $file_name
 * @property string $file_ext
 * @property int $id
 * @property int $id_obj
 */
class FileComment extends ActiveRecord
{
    public static function tableName()
    {
        return 'file_comments';
    }

    public function rules()
    {
        return [
            [['file_name', 'file_ext'], 'required'],
            [['id_obj', 'id_atz'], 'default', 'value' => 'null'],
            [['archived'], 'default', 'value' => false]
        ];
    }
}