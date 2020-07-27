<?php

use yii\db\Migration;

/**
 * Class m200709_121944_add_coll_org
 */
class m200709_121944_add_coll_org extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organizations','is_new',$this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200709_121944_add_coll_org cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200709_121944_add_coll_org cannot be reverted.\n";

        return false;
    }
    */
}
