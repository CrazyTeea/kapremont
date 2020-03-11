<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $pdfFile;

    public function rules()
    {
        return[
            [['pdfFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }
}