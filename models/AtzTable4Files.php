<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atz_table4_files".
 *
 * @property int $id
 * @property string|null $file
 * @property int|null $id_org
 * @property int|null $type
 * @property int|null $id_tab4
 */
class AtzTable4Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_table4_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'string'],
            [['id_org', 'type','id_tab4'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'id_org' => 'Id Org',
            'type' => 'Type',
        ];
    }
}
