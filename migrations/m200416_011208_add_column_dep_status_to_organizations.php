<?php

use app\models\Organizations;
use yii\db\Migration;

/**
 * Class m200416_011208_add_column_dep_status_to_organizations
 */
class m200416_011208_add_column_dep_status_to_organizations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organizations', 'dep_status', 'ENUM("not", "approved", "rejected") after programm_status');

        Organizations::updateAll(['dep_status' => 'not']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organizations', 'dep_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200416_011208_add_column_dep_status_to_organizations cannot be reverted.\n";

        return false;
    }
    */
}
