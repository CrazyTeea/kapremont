<?php

use yii\db\Migration;

/**
 * Class m200318_124816_add_prog_column_status
 */
class m200318_124816_add_prog_column_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'status',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200318_124816_add_prog_column_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200318_124816_add_prog_column_status cannot be reverted.\n";

        return false;
    }
    */
}
