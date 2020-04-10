<?php

namespace app\models;

use yii\db\ActiveRecord;

/***
 * Class ApproveStatus
 * @package app\models
 * @property integer $id
 * @property string $status
 * @property string $label
 */

class ApproveStatus extends ActiveRecord
{
    const STATUS_RECOMEND = 2;
    const STATUS_NOT_RECOMEND = 3;
    const STATUS_TO_WORK = 4;

    public static function tableName()
    {
        return 'approve_status';
    }

    public function getObgect()
    {
        return $this->hasMany(ProgramObjects::class, ['status' => 'id']);
    }
}