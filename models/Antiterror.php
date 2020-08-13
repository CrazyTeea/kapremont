<?php

namespace app\models;

use yii\db\ActiveRecord;

class Antiterror extends ActiveRecord
{
    public static function tableName()
    {
        return 'real_estate_antiterror';
    }
}