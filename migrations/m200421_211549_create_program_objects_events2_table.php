<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%program_objects_events2}}`.
 */
class m200421_211549_create_program_objects_events2_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%program_objects_events2}}', [
            'id' => $this->primaryKey(),
            'id_event'=>$this->integer(),
            'step'=>$this->integer(),
            'step_name'=>$this->text(),
            'date_event_start'=>$this->date(),
            'date_event_end'=>$this->date(),
            'cost_real'=>$this->decimal(22,3),
            'sum_bud_fin'=>$this->decimal(22,3),
            'fin_vnebud_ist'=>$this->decimal(22,3),
            'is_nessesary'=>$this->boolean()->defaultValue(false),
            'done'=>$this->boolean()->defaultValue(false),
            'doneExpert'=>$this->boolean()->defaultValue(false),
            'comment'=>$this->text(),
            'commentExpert'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%program_objects_events2}}');
    }
}
