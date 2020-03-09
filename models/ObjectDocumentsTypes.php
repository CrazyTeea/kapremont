<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object_documents_types".
 *
 * @property int $id
 * @property string $descriptor
 * @property string $label
 */
class ObjectDocumentsTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_documents_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descriptor', 'label'], 'required'],
            [['descriptor', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descriptor' => 'Descriptor',
            'label' => 'Label',
        ];
    }
}
