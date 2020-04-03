<?php

use yii\db\Migration;

/**
 * Class m200403_073434_change_statuses
 */
class m200403_073434_change_statuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200403_073434_change_statuses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200403_073434_change_statuses cannot be reverted.\n";

        return false;
    }
    */
}
