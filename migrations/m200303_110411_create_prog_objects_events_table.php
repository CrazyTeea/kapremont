<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prog_objects_events}}`.
 */
class m200303_110411_create_prog_objects_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prog_objects_events}}', [
            'id' => $this->primaryKey(),
            'step'=>$this->integer()->notNull(),
            'id_object'=>$this->integer()->notNull(),
            'date_event_start'=>$this->date(),
            'date_event_end'=>$this->date(),
            'cost_real'=>$this->decimal(),
            'sum_bud_fin'=>$this->decimal(),
            'fin_vnebud_ist'=>$this->decimal()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prog_objects_events}}');
    }
}
