<?php

use yii\db\Migration;

/**
 * Class m200219_211820_add_id_org_to_program
 */
class m200219_211820_add_id_org_to_program extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'id_org',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200219_211820_add_id_org_to_program cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200219_211820_add_id_org_to_program cannot be reverted.\n";

        return false;
    }
    */
}
