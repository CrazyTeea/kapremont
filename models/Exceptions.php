<?php


namespace app\models;

use yii\db\ActiveRecord;

class Exceptions extends ActiveRecord
{
    public static function tableName()
    {
        return 'exceptions';
    }
}