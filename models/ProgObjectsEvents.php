<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prog_objects_events".
 *
 * @property int $id
 * @property int $step
 * @property int $id_object
 * @property string|null $date_event_start
 * @property string|null $date_event_end
 * @property float|null $cost_real
 * @property float|null $sum_bud_fin
 * @property float|null $fin_vnebud_ist
 * @property boolean $is_nessesary
 */
class ProgObjectsEvents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prog_objects_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step', 'id_object'], 'required'],
            [['step', 'id_object'], 'integer'],
            [['date_event_start', 'date_event_end'], 'safe'],
            [['cost_real', 'sum_bud_fin', 'fin_vnebud_ist'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step' => 'Step',
            'id_object' => 'Id Object',
            'date_event_start' => 'Date Event Start',
            'date_event_end' => 'Date Event End',
            'cost_real' => 'Cost Real',
            'sum_bud_fin' => 'Sum Bud Fin',
            'fin_vnebud_ist' => 'Fin Vnebud Ist',
        ];
    }
}
