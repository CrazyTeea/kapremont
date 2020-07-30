<?php

namespace app\models;

use yii\db\ActiveRecord;

class AntiterrorPassport extends ActiveRecord
{
    public static function tableName()
    {
        return 'atz_passport';
    }
}