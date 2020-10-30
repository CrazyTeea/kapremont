<?php

use yii\db\Migration;

/**
 * Class m201029_083233_sub_systems_table4
 */
class m201029_083233_sub_systems_table4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sub_systems_table4', [
            'id' => $this->primaryKey(),
            'id_card' => $this->integer(),
            'cost_type' => $this->string(),
            'field_name' => $this->string(),
            'value' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sub_systems_table4');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201029_083233_sub_systems_table4 cannot be reverted.\n";

        return false;
    }
    */
}
