<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_info".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $st_sr_count
 * @property int|null $st_fed_count
 * @property int|null $st_dog_count
 * @property int|null $st_in_count
 * @property int|null $prof_count
 * @property int|null $st_all
 * @property int|null $st_sr_pr_count
 * @property int|null $st_bak_count
 * @property int|null $st_spec_count
 * @property int|null $st_mag_count
 * @property int|null $st_asp_count
 * @property int|null $rab_count
 * @property int|null $nauch_rab
 * @property int|null $prof_prep_count
 * @property int|null $in_kat_rab
 * @property int|null $invalid_count
 * @property int|null $zdan_count
 * @property float|null $square_all
 * @property float|null $square_all_kap
 * @property float|null $square_all_av
 * @property float|null $square_all_atz
 */
class OrgInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org',
                'st_sr_count', 'st_fed_count',
                'st_dog_count', 'st_in_count',
                'prof_count', 'st_all', 'st_sr_pr_count',
                'st_bak_count', 'st_spec_count', 'st_mag_count',
                'st_asp_count', 'rab_count', 'nauch_rab',
                'prof_prep_count', 'in_kat_rab', 'invalid_count',
                'zdan_count'], 'integer'],
            [['square_all','square_all_kap','square_all_av','square_all_atz'],'number']
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
            'st_sr_count' => 'St Sr Count',
            'st_fed_count' => 'St Fed Count',
            'st_dog_count' => 'St Dog Count',
            'st_in_count' => 'St In Count',
            'prof_count' => 'Prof Count',
            'st_all' => 'St All',
            'st_sr_pr_count' => 'St Sr Pr Count',
            'st_bak_count' => 'St Bak Count',
            'st_spec_count' => 'St Spec Count',
            'st_mag_count' => 'St Mag Count',
            'st_asp_count' => 'Аспиранты',
            'rab_count' => 'Rab Count',
            'nauch_rab' => 'Nauch Rab',
            'prof_prep_count' => 'Prof Prep Count',
            'in_kat_rab' => 'In Kat Rab',
            'invalid_count' => 'Invalid Count',
            'zdan_count' => 'Zdan Count',
            'square_all'=>'Общая площадь всех зданий и сооружений',
            'square_all_kap'=>'Общая площадь всех зданий и сооружений, требующих капитального ремонта (на основании акта обследования или предписаний надзорных органов)',
            'square_all_av'=>'Общая площадь всех зданий и сооружений, находящихся в аварийном состоянии ',
            'square_all_atz'=>'Общая площадь всех зданий и сооружений, требующих мероприятий по АТЗ',
        ];
    }
}
