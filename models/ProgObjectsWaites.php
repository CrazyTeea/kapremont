<?php

namespace app\models;

/**
 * This is the model class for table "prog_objects_waites".
 *
 * @property int $id
 * @property int $id_object
 * @property string|null $aim
 * @property string|null $plan
 * @property string|null $changes
 * @property string $element
 */
class ProgObjectsWaites extends BaseMultiModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prog_objects_waites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object'], 'required'],
            [['element', 'id_object'], 'integer'],
            [['plan', 'changes'], 'string', 'max' => 255],
            ['aim', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_object' => 'Id Object',
            'aim' => 'Aim',
            'plan' => 'Plan',
            'changes' => 'Changes',
        ];
    }
}
