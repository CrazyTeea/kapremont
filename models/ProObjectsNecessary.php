<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pro_objects_necessary".
 *
 * @property int $id
 * @property int $id_object
 * @property int|null $nalichie
 * @property string|null $material
 * @property string|null $srok_eks
 * @property int|null $kap_remont
 * @property string|null $obosnovanie
 * @property int|null $system_status
 * @property int $element
 */
class ProObjectsNecessary extends BaseMultiModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pro_objects_necessary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object'], 'required'],
            [['id_object', 'nalichie', 'kap_remont', 'system_status','element'], 'integer'],
            [['material', 'srok_eks', 'obosnovanie'], 'string', 'max' => 255],
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
            'nalichie' => 'Nalichie',
            'material' => 'Material',
            'srok_eks' => 'Srok Eks',
            'kap_remont' => 'Kap Remont',
            'obosnovanie' => 'Obosnovanie',
            'system_status' => 'System Status',
        ];
    }
}
