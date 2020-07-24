<?php

use yii\db\Migration;

/**
 * Class m200219_215911_add_id_region_to_orgs
 */
class m200219_215911_add_id_region_to_orgs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'id_region',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200219_215911_add_id_region_to_orgs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200219_215911_add_id_region_to_orgs cannot be reverted.\n";

        return false;
    }
    */
}
