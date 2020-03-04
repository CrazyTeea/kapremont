<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prog_objects_waites}}`.
 */
class m200304_203054_create_prog_objects_waites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prog_objects_waites}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer()->notNull(),
            'aim'=> $this->string(255),
            'plan'=>$this->string(),
            'changes'=>$this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prog_objects_waites}}');
    }
}
