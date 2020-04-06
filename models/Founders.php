<?php


namespace app\models;


use yii\db\ActiveRecord;

class Founders extends ActiveRecord
{
    public function rules()
    {
       return [
           ['id','integer'],
           ['name','string'],
       ];
    }
}