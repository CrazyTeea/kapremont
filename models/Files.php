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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file','file'],
            [['name', 'ext'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ext' => 'Ext',
        ];
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param bool $extPath
     * @return int|null
     * @throws \yii\base\Exception
     */
    public function upload(UploadedFile $uploadedFile, $extPath = false){
        $path = Yii::getAlias( '@webroot' ) . '/uploads';
        if ( $extPath )
            $path .= $extPath;
        if ( !file_exists( $path ) )
            FileHelper::createDirectory( $path );
        $this->name = $uploadedFile->baseName;
        $this->ext = $uploadedFile->extension;
        if ($uploadedFile->saveAs("$path/$uploadedFile->baseName") and $this->save())
            return $this->id;
        return null;
    }
}
