<?php

use yii\db\Migration;

/**
 * Class m200805_083546_exception_logs
 */
class m200805_083546_exception_logs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('exceptions', [
            'id' => $this->primaryKey(),
            'exception_message' => $this->string(1000),
            'description' => $this->string(),
            'class_name' => $this->string(),
            'method' => $this->string(),
            'id_user' => $this->string(),
            'date_time' => $this->dateTime(),
            'extra_info' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('exceptions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200805_083546_exception_logs cannot be reverted.\n";

        return false;
    }
    */
}
