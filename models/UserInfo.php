<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $role
 * @property string|null $name
 * @property string|null $position
 * @property string|null $phone
 * @property string|null $email
 *
 * @property UserInfoRoles $role0
 */
class UserInfo extends BaseMultiModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'role'], 'integer'],
            [['name', 'email'], 'string'],
            [['position', 'phone'], 'string', 'max' => 255],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfoRoles::className(), 'targetAttribute' => ['role' => 'id']],
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
            'role' => 'Role',
            'name' => 'Name',
            'position' => 'Position',
            'phone' => 'Phone',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Role0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserInfoRoles::className(), ['id' => 'role']);
    }
}
