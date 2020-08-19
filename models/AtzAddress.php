<?php

namespace app\models;

use yii\db\ActiveRecord;

class AtzAddress extends ActiveRecord
{
    public static function tableName()
    {
        return 'atz_address';
    }
}