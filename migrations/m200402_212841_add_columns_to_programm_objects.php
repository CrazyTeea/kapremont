<?php

use app\models\ProgramObjects;
use yii\db\Migration;

/**
 * Class m200402_212841_add_columns_to_programm_objects
 */
class m200402_212841_add_columns_to_programm_objects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('program_objects', 'dep_status', "ENUM('not', 'approved', 'rejected')");
        $this->addColumn('program_objects', 'dku_status', "ENUM('not', 'approved', 'rejected')");

        ProgramObjects::updateAll(['dep_status' => 'not']);
        ProgramObjects::updateAll(['dku_status' => 'not']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('program_objects', 'dep_status');
        $this->dropColumn('program_objects', 'dku_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200402_212841_add_columns_to_programm_objects cannot be reverted.\n";

        return false;
    }
    */
}
