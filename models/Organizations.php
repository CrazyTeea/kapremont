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


    public function getProgramObjects()
    {
        return $this->hasMany(ProgramObjects::class, ['id_org' => 'id']);
    }
    public function getProgram(){
        return $this->hasOne(Program::class,['id_org'=>'id']);
    }

    public static function getMainCheckTable($offset, $whereClouse, $order)
    {
        $query = Yii::$app->db
            ->createCommand("
                SELECT 
                    res.id, res.name, res.region, res.quantity, pr.file_exist, pr.p_status
                FROM
                    (SELECT 
                        org.id, org.name, COUNT(po.id_org) AS quantity, reg.region
                    FROM
                        organizations AS org
                    JOIN regions AS reg ON org.id_region = reg.id
                    JOIN program_objects po ON org.id = po.id_org
                    WHERE
                        org.system_status = 1
                    GROUP BY po.id_org
                    ) AS res
                        JOIN
                    program pr ON pr.id_org = res.id
                    where 1 $whereClouse
                ORDER BY $order
                LIMIT 10
                OFFSET $offset")
            ->queryAll();

        return $query;
    }

    public static function getMainCheckTableCount($params)
    {
        $count = Yii::$app->db->createCommand("
            SELECT 
                    COUNT(res.id) as quantity
                FROM
                    (SELECT 
                        org.id, org.name, COUNT(po.id_org) AS quantity, reg.region
                    FROM
                        organizations AS org
                    JOIN regions AS reg ON org.id_region = reg.id
                    JOIN program_objects po ON org.id = po.id_org
                    WHERE
                        org.system_status = 1
                    GROUP BY po.id_org
                    ) AS res
                        JOIN
                    program pr ON pr.id_org = res.id
                where 1 $params
                ORDER BY res.id
            ")->queryOne();

        return $count;
    }
}
