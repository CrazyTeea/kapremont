<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "program_objects_events2".
 *
 * @property int $id
 * @property int|null $id_event
 * @property int|null $id_object
 * @property int|null $step
 * @property string|null $step_name
 * @property string|null $date_event_start
 * @property string|null $date_event_end
 * @property float|null $cost_real
 * @property float|null $sum_bud_fin
 * @property float|null $fin_vnebud_ist
 * @property int|null $is_nessesary
 * @property int|null $done
 * @property int|null $doneExpert
 * @property string|null $comment
 * @property string $access_document
 * @property string|null $commentExpert
 */
class ProgramObjectsEvents2 extends \yii\db\ActiveRecord
{
    public $file_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program_objects_events2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_nessesary','id_object'], 'integer'],
            [['step_name', 'comment', 'commentExpert','access_document','file_name'], 'string'],
            [['date_event_start','id_event',  'done', 'doneExpert', 'date_event_end'], 'safe'],
            [['step', 'cost_real', 'sum_bud_fin', 'fin_vnebud_ist'], 'number'],
        ];
    }
    public function getFile(){
        return $this->hasOne(EventsFiles::class,['id_event2'=>'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_event' => 'Id Event',
            'step' => 'Step',
            'step_name' => 'Step Name',
            'date_event_start' => 'Date Event Start',
            'date_event_end' => 'Date Event End',
            'cost_real' => 'Cost Real',
            'sum_bud_fin' => 'Sum Bud Fin',
            'fin_vnebud_ist' => 'Fin Vnebud Ist',
            'is_nessesary' => 'Is Nessesary',
            'done' => 'Done',
            'doneExpert' => 'Done Expert',
            'comment' => 'Comment',
            'commentExpert' => 'Comment Expert',
        ];
    }
}
