<?php

use app\models\Organizations;
use yii\db\Migration;

/**
 * Class m200412_010718_add_status_to_organizations
 */
class m200412_010718_add_status_to_organizations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organizations', 'programm_status', "ENUM('draft', 'rejected', 'in_process', 'returned', 'dep_reviewed', 'dku_reviewed')");

        Organizations::updateAll(['programm_status' => 'draft']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organizations', 'programm_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200412_010718_add_status_to_organizations cannot be reverted.\n";

        return false;
    }
    */
}
