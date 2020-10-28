<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atz_files".
 *
 * @property int $id
 * @property string|null $file
 * @property int|null $id_atz
 * @property int|null $id_org
 * @property int|null $type
 *
 * @property Atz $atz
 * @property Organizations $org
 */
class AtzFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'string'],
            [['id_atz', 'id_org','type'], 'integer'],
            [['id_atz'], 'exist', 'skipOnError' => true, 'targetClass' => Atz::className(), 'targetAttribute' => ['id_atz' => 'id']],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
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
            'id_atz' => 'Id Atz',
            'id_org' => 'Id Org',
        ];
    }

    /**
     * Gets query for [[Atz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtz()
    {
        return $this->hasOne(Atz::className(), ['id' => 'id_atz']);
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
