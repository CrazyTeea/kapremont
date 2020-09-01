<?php

namespace app\models;

/**
 * This is the model class for table "atz".
 *
 * @property int $id
 * @property int|null $id_program
 * @property string|null $cost_b
 * @property string|null $cost_v
 * @property string|null $cost_o
 * @property int|null $elem
 */
class Atz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_program', 'elem'], 'integer'],
            [['cost_b', 'cost_v', 'cost_o'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_program' => 'Id Program',
            'cost_b' => 'Cost B',
            'cost_v' => 'Cost V',
            'cost_o' => 'Cost O',
            'elem' => 'Elem',
        ];
    }
}
