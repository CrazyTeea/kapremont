<?php

use yii\db\Migration;

/**
 * Class m200405_140801_add_user_status_to_program_table
 */
class m200405_140801_add_user_status_to_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'user_status',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200405_140801_add_user_status_to_program_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200405_140801_add_user_status_to_program_table cannot be reverted.\n";

        return false;
    }
    */
}
