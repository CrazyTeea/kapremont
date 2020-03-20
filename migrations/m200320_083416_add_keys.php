<?php

use yii\db\Migration;

/**
 * Class m200320_083416_add_keys
 */
class m200320_083416_add_keys extends Migration
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
        echo "m200320_083416_add_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200320_083416_add_keys cannot be reverted.\n";

        return false;
    }
    */
}
