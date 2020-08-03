<?php

namespace app\models;

use yii\db\ActiveRecord;

class AtzTypeActivity extends ActiveRecord
{
    public static function tableName()
    {
        return 'atz_type_activity';
    }
}