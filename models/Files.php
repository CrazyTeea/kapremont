<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $ext
 */
class Files extends \yii\db\ActiveRecord
{
    public $file;

    public static function tableName()
    {
        return 'files';
    }

    public function rules()
    {
        return [
            ['file','file'],
            [['name', 'ext'], 'string', 'max' => 255],
        ];
    }

    public function attribute()
    {
        return [
            'id',
            'name',
            'ext',
            'path',
            'size',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ext' => 'Ext',
            'path' => 'Path',
            'size' => 'Size'
        ];
    }

    public function getObjList()
    {
        return $this->hasOne(ObjectDocumentsList::class, ['id_file' => 'id']);
    }

    public function upload(UploadedFile $uploadedFile, $extPath = false)
    {
        $path = Yii::getAlias( '@webroot' ) . '/uploads';
        if ( $extPath )
            $path .= $extPath;
        if ( !file_exists( $path ) )
            FileHelper::createDirectory( $path );
        $this->name = $uploadedFile->baseName;
        $this->ext = $uploadedFile->extension;
        if ($uploadedFile->saveAs("$path/$uploadedFile->baseName.$uploadedFile->extension") and $this->save())
            return $this->id;
        return null;
    }
}
