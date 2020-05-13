<?php

namespace app\models;

use Yii;
use app\models\ProgramObjects;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property int $id_region
 * @property string|null $full_name
 * @property string|null $name
 * @property string|null $short_name
 * @property int|null $system_status
 * @property  OrgInfo $orgInfo
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'name', 'short_name'], 'string'],
            [['system_status'], 'integer'],
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

    public function getRegion(){
        return $this->hasOne(Regions::className(),['id'=>'id_region']);
    }
    public function getOrgInfo(){
        return $this->hasOne(OrgInfo::className(),['id_org'=>'id']);
    }
    public function getUserInfo(){
        return $this->hasMany(UserInfo::class,['id_org'=>'id']);
    }

    public function getProgramObjects()
    {
        return $this->hasMany(ProgramObjects::class, ['id_org' => 'id']);
    }
    public function getProgram(){
        return $this->hasOne(Program::class,['id_org'=>'id']);
    }
    public function getFounder(){
        return $this->hasOne(Founders::class,['id_founder'=>'id']);
    }

    private static function CalculateState($orgs){
        $state = null;
        if($orgs === 'other') {
            $rolesId = array_merge(User::getUsersByRole('faiv_admin'), User::getUsersByRole('faiv_user')) ;
            $users = User::find()->where(['id'=> $rolesId])->all();
            $orgIds = [];
            foreach($users as $user) {
                $orgIds[] = $user->id_org;
            }
            $array = implode(', ', array_unique($orgIds));
            if($array) {
                $state = "and org.id in ($array)";
            } else {
                $state = null;
            }
        } else {
            $state = null;
        }
        return $state;
    }

    public static function getMainCheckTable($offset, $whereClouse, $order, $orgs, $faiv = null)
    {
        $state = self::CalculateState($orgs);

        $query = Yii::$app->db
            ->createCommand("
                SELECT 
                    res.id, res.name, res.region, res.quantity, res.dep_status, res.dku_status, pr.file_exist, pr.p_status,pr.dku_atz,pr.status907
                FROM
                    (SELECT 
                        org.id, org.name, COUNT(po.id_org) AS quantity, reg.region, org.dep_status, org.dku_status
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
                    where 1 and pr.status907=0 $whereClouse
                ORDER BY $order
                LIMIT 10
                OFFSET $offset")
            ->queryAll();

        return $query;
    }

    public static function getMainCheckTableCount($params,$orgs, $faiv = null)
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
}
