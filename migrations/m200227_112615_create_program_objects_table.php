<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%program_objects}}`.
 */
class m200227_112615_create_program_objects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%program_objects}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'id_priority'=>$this->integer(),
            'id_program'=>$this->integer(),
            'name'=>$this->text(),
            'assignment'=>$this->text(),
            'square'=>$this->decimal(),
            'year'=>$this->integer(),
            'wear'=>$this->decimal(),
            'regulation'=>$this->text(),
            'event_type'=>$this->text(),
            'finance_sum'=>$this->decimal(),
            'coFinancing'=>$this->decimal(),
            'note'=>$this->text(),
            'system_status'=>$this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%program_objects}}');
    }
}
