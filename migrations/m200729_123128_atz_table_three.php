<?php

use yii\db\Migration;

/**
 * Class m200729_123128_atz_table_three
 */
class m200729_123128_atz_table_three extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('atz_table_three', [
            'id' => $this->primaryKey(),
            'id_object' => $this->integer(),
            'id_org' => $this->integer(),
            'object' => $this->string(),
            'video_system' => $this->string(),
            'evacuation_system' => $this->string(),
            'light_system' => $this->string(),
            'predator_system' => $this->string(),
            'alarm_warning_system' => $this->string(),
            'alarm_fire_system' => $this->string(),
            'phone_system' => $this->string(),
            'fence' => $this->string(),
            'skud' => $this->string()
        ]);

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atz_table_three');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200729_123128_atz_table_three cannot be reverted.\n";

        return false;
    }
    */
}
