<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "program".
 *
 * @property int $id
 * @property float|null $finance_volume
 * @property float|null $finance_events
 * @property float|null $cost
 * @property int|null $system_status
 * @property int|null $id_org
 * @property int $file_exist
 * @property int $p_status
 * @property int $status907
 * @property float $dku_atz
 * @property float $cost2
 */
class Program extends ActiveRecord
{
    public const ACTIVE = 1;

    public $organization;

    public static function tableName()
    {
        return 'program';
    }

    public function getObjects()
    {
        return $this->hasMany(ProgramObjects::class, ['id_program' => 'id'])->andOnCondition([ProgramObjects::tableName() . '.system_status' => 1]);
    }

    public function getOrg()
    {
        return $this->hasOne(Organizations::class, ['id' => 'id_org']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finance_volume', 'finance_events', 'cost', 'p_status', 'dku_atz','cost2'], 'number'],
            [['system_status', 'id_org'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'finance_volume' => 'Finance Volume',
            'finance_events' => 'Finance Events',
            'cost' => 'Cost',
            'system_status' => 'System Status',
            'id_org' => 'Id Org',
        ];
    }

}
