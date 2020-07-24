<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%program}}`.
 */
class m200219_210942_create_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%program}}', [
            'id' => $this->primaryKey(),
            'finance_volume'=>$this->float(),
            'finance_events'=>$this->float(),
            'cost'=>$this->float(),
            'system_status'=>$this->integer()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%program}}');
    }
}
