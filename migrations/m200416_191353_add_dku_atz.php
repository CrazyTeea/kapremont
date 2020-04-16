<?php

use yii\db\Migration;

/**
 * Class m200416_191353_add_dku_atz
 */
class m200416_191353_add_dku_atz extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'dku_atz',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200416_191353_add_dku_atz cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200416_191353_add_dku_atz cannot be reverted.\n";

        return false;
    }
    */
}
