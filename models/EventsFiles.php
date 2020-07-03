<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "events_files".
 *
 * @property int $id
 * @property int $id_event
 * @property int $id_event2
 * @property string|null $file_name
 *
 * @property ProgObjectsEvents $event
 * @property ProgramObjectsEvents2 $event2
 */
class EventsFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_event', 'id_event2'], 'integer'],
            [['file_name'], 'string'],
            [['id_event'], 'exist', 'skipOnError' => true, 'targetClass' => ProgObjectsEvents::className(), 'targetAttribute' => ['id_event' => 'id']],
            [['id_event2'], 'exist', 'skipOnError' => true, 'targetClass' => ProgramObjectsEvents2::className(), 'targetAttribute' => ['id_event2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_event' => 'Id Event',
            'id_event2' => 'Id Event2',
            'file_name' => 'File Name',
        ];
    }

    /**
     * @param UploadedFile $file
     * @param null $id_event
     * @param null $id_event2
     * @return array|string[]
     * @throws \yii\base\Exception
     */
    public static function UploadOrUpdate(UploadedFile $file, $id_event = null, $id_event2 = null){
        if (!$id_event and !$id_event2)
            return ['error'=>'не верный id'];
        $f = new self();
        if ($id_event){
            $f = self::findOne(['id_event'=>$id_event]) ? : new self();
            $f->id_event = $id_event;
            $f->file_name = $file->name;
        }
        if ($id_event2) {
            $f = self::findOne(['id_event2'=>$id_event2]) ? : new self();
            $f->id_event2 = $id_event2;
            $f->file_name = $file->name;

        }
        $flag = $f->save();
        $path = '';

        if ($id_event)
            $path= Yii::getAlias('@webroot')."/uploads/events/1/{$id_event}";
        if ($id_event2)
            $path= Yii::getAlias('@webroot')."/uploads/events/2/{$id_event2}";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $path .= "/{$file->name}";
        if (file_exists($path))
            unlink($path);
        $file->saveAs($path);
        return ['success'=>$flag,'errors'=>$f->getErrors(),'file'=>file_exists($path)];
    }
    public static function download($id_event){
        $f = self::findOne(['id_event'=>$id_event]);
        if (!$f)
            $f= self::findOne(['id_event2'=>$id_event]);
        if (!$f)
            return 'Файл не найден';
        $path = '';
        if ($f->id_event)
            $path= Yii::getAlias('@webroot')."/uploads/events/1/{$f->id_event}";
        if ($f->id_event2)
            $path= Yii::getAlias('@webroot')."/uploads/events/2/{$f->id_event2}";

        $path .= "/{$f->file_name}";
        if (file_exists($path))
            return Yii::$app->response->sendFile($path);
        return 'Файл не найден';
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(ProgObjectsEvents::className(), ['id' => 'id_event']);
    }

    /**
     * Gets query for [[Event2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent2()
    {
        return $this->hasOne(ProgramObjectsEvents2::className(), ['id' => 'id_event2']);
    }
}
