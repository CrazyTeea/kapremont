<?php

namespace app\models;

/**
 * This is the model class for table "atz_address".
 *
 * @property int $id
 * @property int|null $id_atz_table_four
 * @property string|null $passport_name
 */
class AtzAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_atz_table_four'], 'integer'],
            [['passport_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_atz_table_four' => 'Id Atz Table Four',
            'passport_name' => 'Passport Name',
        ];
    }
}
