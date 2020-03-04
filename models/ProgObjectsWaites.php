<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prog_objects_waites".
 *
 * @property int $id
 * @property int $id_object
 * @property string|null $aim
 * @property string|null $plan
 * @property string|null $changes
 */
class ProgObjectsWaites extends \yii\db\ActiveRecord
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
            [['id_object'], 'integer'],
            [['aim', 'plan', 'changes'], 'string', 'max' => 255],
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
