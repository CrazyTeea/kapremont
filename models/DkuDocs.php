<?php

namespace app\models;

use phpDocumentor\Reflection\Types\AbstractList;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "dku_docs".
 *
 * @property int $id
 * @property int|null $id_org
 * @property string|null $file_name
 *
 * @property Organizations $org
 */
class DkuDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dku_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org'], 'integer'],
            [['file_name'], 'string'],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
        ];
    }
    public function addDoc(UploadedFile $file,$id_org){
        $this->id_org = $id_org;
        $this->file_name = $file->name;
        $path = Yii::getAlias('@webroot')."/uploads/dku_docs/$id_org";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $path.="/{$this->file_name}";
        $file->saveAs($path);
        $file = $path;
        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'file_name' => 'File Name',
        ];
    }

    /**
     * Gets query for [[Org]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'id_org']);
    }
}
