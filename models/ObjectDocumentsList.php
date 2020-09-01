<?php

namespace app\models;

use yii\web\UploadedFile;

/**
 * This is the model class for table "object_documents_list".
 *
 * @property int $id
 * @property int $id_object
 * @property int $system_status
 * @property int $id_file
 * @property int $id_type
 * @property string $label
 */
class ObjectDocumentsList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_documents_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'string'],
            [['id_object', 'id_file', 'id_type'], 'required'],
            [['id_object', 'id_file', 'id_type', 'system_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_object' => 'Id Object',
            'id_file' => 'Id File',
            'id_type' => 'Id Type',
        ];
    }

    public function getType()
    {
        return $this->hasOne(ObjectDocumentsTypes::className(), ['id' => 'id_type']);
    }

    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'id_file']);
    }

    public function add(UploadedFile $uploadedFile, $id_object, $id_type, $label, $status = 1)
    {
        $ifDoc = self::findOne(['id_object' => $id_object, 'id_type' => $id_type, 'system_status' => 1]);
        if (!$ifDoc) {
            $file = new Files();
            $this->id_file = $file->upload($uploadedFile, "/$id_object");
            $this->id_object = $id_object;
            $this->id_type = $id_type;
            $this->label = $label;
            $this->system_status = $status;
            return $this->id_file and $this->save();
        }
        $file = new Files();
        $ifDoc->id_file = $file->upload($uploadedFile, "/$id_object");
        return $ifDoc->id_file and $ifDoc->save(false);

    }

    public function updateItem($id)
    {
        self::update(['system_status' => 0])->where(['id' => $id]);
    }

    public function getTypes()
    {
        return $this->hasMany(ObjectDocumentsTypes::class, ['id' => 'id_type']);
    }

    public function getFiles()
    {
        return $this->hasMany(Files::class, ['id' => 'id_file']);
    }


    public function getObject()
    {
        return $this->hasOne(ProgramObjects::class, ['id_object' => 'id']);
    }

}
