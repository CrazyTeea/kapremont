<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atz_type_activity".
 *
 * @property int $id
 * @property int|null $id_atz_table_for_address
 * @property string|null $name
 * @property string|null $value
 */
class AtzTypeActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_type_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_atz_table_for_address'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_atz_table_for_address' => 'Id Atz Table For Address',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
