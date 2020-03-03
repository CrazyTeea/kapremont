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
 * @property int|null $id_region
 * @property int|null $id_city
 * @property string|null $address
 * @property string|null $exist_pred_nadz_orgs
 * @property int|null $type
 * @property string|null $prav_sob
 * @property float|null $square_kap
 * @property float|null $isp_v_ust_dey
 * @property float|null $n_isp_v_ust_dey
 * @property float|null $square_ar
 * @property string|null $kad_number
 * @property int|null $exploit_year
 * @property string|null $osn_isp_zdan
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
            [['id_org', 'id_priority', 'id_program', 'year', 'system_status', 'id_region', 'id_city', 'type', 'exploit_year'], 'integer'],
            [['name', 'assignment', 'regulation', 'event_type', 'note', 'address'], 'string'],
            [['square', 'wear', 'finance_sum', 'coFinancing', 'square_kap', 'isp_v_ust_dey', 'n_isp_v_ust_dey', 'square_ar'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['exist_pred_nadz_orgs', 'prav_sob', 'kad_number', 'osn_isp_zdan'], 'string', 'max' => 255],
            [['id_org','id_program'],'required']
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
            'id_region' => 'Id Region',
            'id_city' => 'Id City',
            'address' => 'Address',
            'exist_pred_nadz_orgs' => 'Exist Pred Nadz Orgs',
            'type' => 'Type',
            'prav_sob' => 'Prav Sob',
            'square_kap' => 'Square Kap',
            'isp_v_ust_dey' => 'Isp V Ust Dey',
            'n_isp_v_ust_dey' => 'N Isp V Ust Dey',
            'square_ar' => 'Square Ar',
            'kad_number' => 'Kad Number',
            'exploit_year' => 'Exploit Year',
            'osn_isp_zdan' => 'Osn Isp Zdan',
        ];
    }
}
