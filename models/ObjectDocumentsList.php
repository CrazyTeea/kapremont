<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "object_documents_list".
 *
 * @property int $id
 * @property int $id_object
 * @property int $id_file
 * @property int $id_type
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
            [['id_object', 'id_file', 'id_type'], 'required'],
            [['id_object', 'id_file', 'id_type'], 'integer'],
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
    public function getType(){
        return $this->hasOne(ObjectDocumentsTypes::className(),['id'=>'id_type']);
    }
    public function getFile(){
        return $this->hasOne(Files::className(),['id'=>'id_file']);
    }
    public function add(UploadedFile $uploadedFile,$id_object,$id_type){
        $file = new Files();
        $this->id_file = $file->upload($uploadedFile,"/$id_object");
        $this->id_object= $id_object;
        $this->id_type= $id_type;
        return $this->id_file and $this->save();
    }
}
