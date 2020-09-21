<?php

use yii\db\Migration;

/**
 * Class m200921_082035_add_id_type_org
 */
class m200921_082035_add_id_type_org extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'id_type',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200921_082035_add_id_type_org cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200921_082035_add_id_type_org cannot be reverted.\n";

        return false;
    }
    */
}
