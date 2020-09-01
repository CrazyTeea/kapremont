<?php

namespace app\models;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property int|null $id_region
 * @property string|null $city
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_region'], 'integer'],
            [['city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_region' => 'Id Region',
            'city' => 'City',
        ];
    }
}
