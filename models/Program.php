<?php

namespace app\models;

use Yii;
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
 */
class Program extends ActiveRecord
{

    public function getObjects(){
        return $this->hasMany(ProgramObjects::class,['id_program'=>'id'])->andOnCondition([ProgramObjects::tableName().'.system_status'=>1]);
    }
    public function getObjectsValid(){
        return $this->hasMany(ProgramObjects::class,['id_program'=>'id'])
            ->andOnCondition([ProgramObjects::tableName().'.system_status'=>1])
            ->andOnCondition(['<>','status',0]);
    }
    public function getOrg(){
        return $this->hasOne(Organizations::class,['id'=>'id_org']);
    }

    public const ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finance_volume', 'finance_events', 'cost','p_status'], 'number'],
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
