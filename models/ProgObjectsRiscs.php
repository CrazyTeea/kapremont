<?php

namespace app\models;

/**
 * This is the model class for table "prog_objects_riscs".
 *
 * @property int $id
 * @property string|null $types
 * @property string|null $poison
 * @property string|null $protect
 * @property string $element
 * @property int|null $id_object
 */
class ProgObjectsRiscs extends BaseMultiModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prog_objects_riscs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['types', 'poison', 'protect'], 'string'],
            [['id_object', 'element'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'types' => 'Types',
            'poison' => 'Poison',
            'protect' => 'Protect',
            'id_object' => 'Id Object',
        ];
    }
}
