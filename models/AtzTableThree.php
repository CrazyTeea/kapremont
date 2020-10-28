<?php

namespace app\models;

/**
 * This is the model class for table "atz_table_three".
 *
 * @property int $id
 * @property int|null $id_object
 * @property int|null $id_org
 * @property string|null $object
 * @property string|null $video_system
 * @property string|null $evacuation_system
 * @property string|null $light_system
 * @property string|null $predator_system
 * @property string|null $alarm_warning_system
 * @property string|null $alarm_fire_system
 * @property string|null $phone_system
 * @property string|null $fence
 * @property string|null $skud
 * @property string|null $video_system_bud
 * @property string|null $video_system_nebud
 * @property string|null $evacuation_system_bud
 * @property string|null $evacuation_system_nebud
 * @property string|null $light_system_bud
 * @property string|null $light_system_nebud
 * @property string|null $predator_system_bud
 * @property string|null $predator_system_nebud
 * @property string|null $alarm_warning_system_bud
 * @property string|null $alarm_warning_system_nebud
 * @property string|null $alarm_fire_system_bud
 * @property string|null $alarm_fire_system_nebud
 * @property string|null $phone_system_bud
 * @property string|null $phone_system_nebud
 * @property string|null $fence_bud
 * @property string|null $fence_nebud
 * @property string|null $skud_bud
 * @property string|null $skud_nebud
 */
class AtzTableThree extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_table_three';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object', 'id_org'], 'integer'],
            [['video_system_bud', 'video_system_nebud', 'evacuation_system_bud', 'evacuation_system_nebud', 'light_system_bud', 'light_system_nebud', 'predator_system_bud', 'predator_system_nebud', 'alarm_warning_system_bud', 'alarm_warning_system_nebud', 'alarm_fire_system_bud', 'alarm_fire_system_nebud', 'phone_system_bud', 'phone_system_nebud', 'fence_bud', 'fence_nebud', 'skud_bud', 'skud_nebud'], 'string'],
            [['object', 'video_system', 'evacuation_system', 'light_system', 'predator_system', 'alarm_warning_system', 'alarm_fire_system', 'phone_system', 'fence', 'skud'], 'string', 'max' => 255],
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
            'id_org' => 'Id Org',
            'object' => 'Object',
            'video_system' => 'Video System',
            'evacuation_system' => 'Evacuation System',
            'light_system' => 'Light System',
            'predator_system' => 'Predator System',
            'alarm_warning_system' => 'Alarm Warning System',
            'alarm_fire_system' => 'Alarm Fire System',
            'phone_system' => 'Phone System',
            'fence' => 'Fence',
            'skud' => 'Skud',
            'video_system_bud' => 'Video System Bud',
            'video_system_nebud' => 'Video System Nebud',
            'evacuation_system_bud' => 'Evacuation System Bud',
            'evacuation_system_nebud' => 'Evacuation System Nebud',
            'light_system_bud' => 'Light System Bud',
            'light_system_nebud' => 'Light System Nebud',
            'predator_system_bud' => 'Predator System Bud',
            'predator_system_nebud' => 'Predator System Nebud',
            'alarm_warning_system_bud' => 'Alarm Warning System Bud',
            'alarm_warning_system_nebud' => 'Alarm Warning System Nebud',
            'alarm_fire_system_bud' => 'Alarm Fire System Bud',
            'alarm_fire_system_nebud' => 'Alarm Fire System Nebud',
            'phone_system_bud' => 'Phone System Bud',
            'phone_system_nebud' => 'Phone System Nebud',
            'fence_bud' => 'Fence Bud',
            'fence_nebud' => 'Fence Nebud',
            'skud_bud' => 'Skud Bud',
            'skud_nebud' => 'Skud Nebud',
        ];
    }
}
