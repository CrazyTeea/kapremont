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
 * @property string $prav_oper_upr
 * @property string|null $exist_pred_nadz_orgs
 * @property int|null $type
 * @property string|null $prav_sob
 * @property float|null $square_kap
 * @property float|null $isp_v_ust_dey
 * @property float|null $n_isp_v_ust_dey
 * @property float|null $square_ar
 * @property string|null $kad_number
 * @property int|null $exploit_year
 * @property int $type_remont
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
            [['id_org', 'id_priority', 'id_program', 'year', 'system_status', 'id_region', 'id_city', 'type', 'exploit_year','type_remont'], 'integer'],
            [['name', 'assignment', 'regulation', 'event_type', 'note', 'address','prav_oper_upr'], 'string','max'=>5000],
            [['square', 'wear', 'finance_sum', 'coFinancing', 'square_kap', 'isp_v_ust_dey', 'n_isp_v_ust_dey', 'square_ar', 'square_av', 'square_atz'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['exist_pred_nadz_orgs', 'prav_sob', 'kad_number', 'osn_isp_zdan','podrobnosti'], 'string', 'max' => 5000],
            [[
                'id_org', 'id_program', 'year', 'id_region', 'id_city', 'type', 'exploit_year',
                'name', 'assignment', 'note', 'square', 'wear', 'address','type_remont',
                'square_kap', 'isp_v_ust_dey', 'n_isp_v_ust_dey', 'square_ar','exist_pred_nadz_orgs', 'kad_number', 'osn_isp_zdan','last_exploit_year'
            ],'required']
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
            'name' => 'Наименование',
            'assignment' => 'Назначение',
            'square' => 'Общая площадь здания - всего, кв.м.:',
            'year' => 'Год постройки здания:',
            'wear' => 'Износ',
            'regulation' => 'Regulation',
            'event_type' => 'Event Type',
            'finance_sum' => 'Finance Sum',
            'coFinancing' => 'Co Financing',
            'note' => 'Примечание',
            'system_status' => 'System Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_region' => 'Регион',
            'id_city' => 'Город',
            'address' => 'Адрес',
            'exist_pred_nadz_orgs' => 'Наличие предписаний надзорных органов:',
            'type' => 'Type',
            'prav_sob' => 'Право собственности:',
            'square_kap' => 'Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.:',
            'isp_v_ust_dey' => 'Используется в уставной деятельности, кв.м.:',
            'n_isp_v_ust_dey' => 'Не используется в уставной деятельности, кв.м.:',
            'square_ar' => 'Предоставлено в аренду, кв.м.',
            'kad_number' => 'Кадастровый номер',
            'exploit_year' => 'Год ввода здания в эксплуатацию:',
            'osn_isp_zdan' => 'Основание для использования здания:',
            'prav_oper_upr'=>'Право оперативного управления (рег. запись, номер):'
        ];
    }
    public function getRegion(){
        return $this->hasOne(Regions::className(),['id'=>'id_region']);
    }

    public function getOrg(){
        return $this->hasOne(Organizations::className(),['id'=>'id_org']);
    }

    public function getDocList()
    {
        return $this->hasMany(ObjectDocumentsList::class, ['id_object' => 'id']);
    }

}
