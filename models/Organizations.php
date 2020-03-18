<?php

namespace app\models;

use Yii;
use app\models\ProgramObjects;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property int $id_region
 * @property string|null $full_name
 * @property string|null $name
 * @property string|null $short_name
 * @property int|null $system_status
 * @property  OrgInfo $orgInfo
 */
class Organizations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'name', 'short_name'], 'string'],
            [['system_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'name' => 'Наименование организации ',
            'short_name' => 'Short Name',
            'system_status' => 'System Status',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id'=>'id_region']);
    }

    public function getProgramObjects()
    {
        return $this->hasMany(ProgramObjects::class, ['id_org' => 'id']);
    }
}
