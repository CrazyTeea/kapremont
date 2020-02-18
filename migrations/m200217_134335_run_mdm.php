<?php

use yii\db\Migration;

/**
 * Class m200217_134335_run_mdm
 */
class m200217_134335_run_mdm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        exec('php yii migrate --migrationPath=@mdm/admin/migrations --interactive=0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200217_134335_run_mdm cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200217_134335_run_mdm cannot be reverted.\n";

        return false;
    }
    */
}
