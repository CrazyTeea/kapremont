<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property int $id_region
 * @property string|null $full_name
 * @property string|null $name
 * @property string|null $short_name
 * @property string|null $inn
 * @property int|null $system_status
 * @property  OrgInfo $orgInfo
 * @property string $dku_comment
 * @property int $id_founder
 * @property int $is_new
 */
class Organizations extends \yii\db\ActiveRecord
{
    public const PROGRAM_STATUS_DRAFT = 'draft';

    public const PROGRAM_STATUS_REJECTED = 'rejected';

    public const PROGRAM_STATUS_IN_PRCESS = 'in_process';

    public const PROGRAM_STATUS_RETURNED = 'returned';

    public const PROGRAM_STATUS_DEP_REVIEWED = 'dep_reviewed';

    public const PROGRAM_STATUS_DKU_REVIEWED = 'dku_reviewed';

    public $quantity;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }

    public static function getMainCheckTable($offset, $whereClouse, $order, $orgs, $faiv = null)
    {
        $state = self::CalculateState($orgs);

        $query = Yii::$app->db
            ->createCommand("
                SELECT 
                    res.id, res.name,res.dku_comment, res.region,res.is_new,res.id_founder,
                     res.quantity, res.dep_status, res.dku_status, pr.file_exist, pr.p_status,pr.dku_atz,pr.status907,res.dku_doc
                FROM
                    (SELECT 
                        org.id, org.name, COUNT(po.id_org) AS quantity, reg.region, org.dep_status, org.dku_status, 
                        org.dku_comment,dd.file_name dku_doc, org.is_new,org.id_founder
                    FROM
                        organizations AS org
                    JOIN regions AS reg ON org.id_region = reg.id
                    JOIN program_objects po ON org.id = po.id_org
                    left join dku_docs dd on dd.id_org = org.id
                    WHERE
                        org.system_status = 1 and po.system_status = 1 $faiv $state
                    GROUP BY po.id_org
                    ) AS res
                        JOIN
                    program pr ON pr.id_org = res.id
                    where 1 and pr.status907=0 $whereClouse
                ORDER BY $order
                LIMIT 10
                OFFSET $offset")
            ->queryAll();

        return $query;
    }

    private static function CalculateState($orgs)
    {
        return ($orgs === 'other' and !Yii::$app->user->can('faiv_admin')) ? 'and org.id_founder > 1' : null;
    }

    public static function getMainCheckTableCount($params, $orgs, $faiv = null)
    {

        $state = self::CalculateState($orgs);

        $count = Yii::$app->db->createCommand("
            SELECT 
                    COUNT(res.id) as quantity, res.region, res.name ,pr.status907
                FROM
                    (SELECT 
                        org.id, reg.region, org.name
                    FROM
                        organizations AS org
                    JOIN regions AS reg ON org.id_region = reg.id
                    JOIN program_objects po ON org.id = po.id_org
                    WHERE
                        org.system_status = 1 $faiv $state
                    GROUP BY po.id_org
                    ) AS res
                        JOIN
                    program pr ON pr.id_org = res.id
                where 1 and pr.status907=0 $params
                ORDER BY res.id
            ")->queryOne();

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'name', 'short_name', 'inn', 'dku_comment'], 'string'],
            [['system_status', 'id_founder', 'is_new'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'name' => 'Наименование организации ',
            'short_name' => 'Short Name',
            'system_status' => 'System Status',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'id_region']);
    }

    public function getOrgInfo()
    {
        return $this->hasOne(OrgInfo::className(), ['id_org' => 'id']);
    }

    public function getUserInfo()
    {
        return $this->hasMany(UserInfo::class, ['id_org' => 'id']);
    }

    public function getProgramObjects()
    {
        return $this->hasMany(ProgramObjects::class, ['id_org' => 'id']);
    }

    public function getProgram()
    {
        return $this->hasOne(Program::class, ['id_org' => 'id']);
    }

    public function getFounder()
    {
        return $this->hasOne(Founders::class, ['id_founder' => 'id']);
    }

    public function getDkuDoc()
    {
        return $this->hasOne(DkuDocs::class, ['id_org' => 'id']);
    }
}
