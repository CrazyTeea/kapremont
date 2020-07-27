<?php

use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;
use yii\db\Migration;

/**
 * Class m200413_190644_add_columns_to_programm
 */
class m200413_190644_add_columns_to_programm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('program_objects', 'dku_status');

        $this->addColumn('organizations', 'dku_status', 'ENUM("not", "approved", "rejected")');

        Organizations::updateAll(['dku_status' => 'not']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organizations', 'dku_status');

        $this->addColumn('program_objects', 'dku_status', 'ENUM("not", "approved", "rejected")');

        ProgramObjects::updateAll(['dku_status' => 'not']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_190644_add_columns_to_programm cannot be reverted.\n";

        return false;
    }
    */
}
