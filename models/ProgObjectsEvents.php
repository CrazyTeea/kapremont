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
 * @property string $access_document
 * @property float|null $cost_real
 * @property float|null $sum_bud_fin
 * @property float|null $fin_vnebud_ist
 * @property boolean $is_nessesary
 * @property int|null $done
 * @property int|null $doneExpert
 * @property string|null $comment
 * @property string|null $commentExpert
 */
class ProgObjectsEvents extends BaseMultiModel
{
    public $file_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prog_objects_events';
    }

    public function getSvedenia2(){
        return $this->hasMany(ProgramObjectsEvents2::class,['id_event'=>'id']);
    }

    public function getFile(){
        return $this->hasOne(EventsFiles::class,['id_event'=>'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_nessesary', 'id_object'], 'integer'],
            [[ 'comment', 'commentExpert','access_document','file_name'], 'string'],
            [['date_event_start', 'date_event_end','done', 'doneExpert'], 'safe'],
            [['step', 'cost_real', 'sum_bud_fin', 'fin_vnebud_ist'], 'number'],
        ];
    }
    public function getObject(){
        return $this->hasOne(ProgramObjects::class,['id'=>'id_object']);
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
