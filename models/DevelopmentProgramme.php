<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "development_programme".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $system_status
 */
class DevelopmentProgramme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'development_programme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'system_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'system_status' => 'System Status',
        ];
    }
}
