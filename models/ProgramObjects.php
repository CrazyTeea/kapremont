<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "program_objects".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $id_priority
 * @property int|null $id_program
 * @property string|null $name
 * @property string|null $assignment
 * @property float|null $square
 * @property int|null $year
 * @property float|null $wear
 * @property string|null $regulation
 * @property string|null $event_type
 * @property float|null $finance_sum
 * @property float|null $coFinancing
 * @property string|null $note
 * @property int|null $system_status
 * @property string $created_at
 * @property string $updated_at
 */
class ProgramObjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program_objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'id_priority', 'id_program', 'year', 'system_status'], 'integer'],
            [['name', 'assignment', 'regulation', 'event_type', 'note'], 'string'],
            [['square', 'wear', 'finance_sum', 'coFinancing'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
            'id_priority' => 'Id Priority',
            'id_program' => 'Id Program',
            'name' => 'Name',
            'assignment' => 'Assignment',
            'square' => 'Square',
            'year' => 'Year',
            'wear' => 'Wear',
            'regulation' => 'Regulation',
            'event_type' => 'Event Type',
            'finance_sum' => 'Finance Sum',
            'coFinancing' => 'Co Financing',
            'note' => 'Note',
            'system_status' => 'System Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
