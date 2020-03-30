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
 * @property int $last_exploit_year
 * @property int $status
 * @var $docList ObjectDocumentsList[]
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
            [['id_org', 'id_priority', 'id_program', 'year', 'system_status', 'id_region', 'id_city', 'type', 'exploit_year','type_remont','last_exploit_year'], 'integer'],
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
            'id_region' => 'Регион',
            'id_city' => 'Город',
            'address' => 'Полный адрес объекта',
            'exist_pred_nadz_orgs' => 'Наличие предписаний надзорных органов:',
            'type' => 'Тип объекта',
            'prav_sob' => 'Право собственности:',
            'square_kap' => 'Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.:',
            'isp_v_ust_dey' => 'Используется в уставной деятельности, кв.м.:',
            'n_isp_v_ust_dey' => 'Не используется в уставной деятельности, кв.м.:',
            'square_ar' => 'Предоставлено в аренду, кв.м.',
            'kad_number' => 'Кадастровый номер',
            'exploit_year' => 'Год ввода здания в эксплуатацию:',
            'osn_isp_zdan' => 'Основание для использования здания:',
            'prav_oper_upr'=>'Право оперативного управления (рег. запись, номер):',
            'last_exploit_year'=>'Год проведения последнего капитального ремонта/реконструкции'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion(){
        return $this->hasOne(Regions::className(),['id'=>'id_region']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg(){
        return $this->hasOne(Organizations::className(),['id'=>'id_org']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocList()
    {
        return $this->hasMany(ObjectDocumentsList::class, ['id_object' => 'id'])->andOnCondition([ObjectDocumentsList::tableName().'.system_status'=>1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNecessary(){
        return $this->hasMany(ProObjectsNecessary::class,['id_object'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWaites(){
        return $this->hasMany(ProgObjectsWaites::class,['id_object'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisks(){
        return $this->hasMany(ProgObjectsRiscs::class,['id_object'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSvedenia(){
        return $this->hasMany(ProgObjectsEvents::class,['id_object'=>'id']);
    }

    public function getAstatus()
    {
        return $this->hasOne(ApproveStatus::class, ['id' => 'status']);
    }

    public function getCity(){
        return $this->hasOne(Cities::class, ['id' => 'id_city']);
    }

    public function getProgram(){
        return $this->hasOne(Program::class, ['id' => 'id_program']);
    }

}
