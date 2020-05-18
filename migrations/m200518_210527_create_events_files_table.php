<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events_files}}`.
 */
class m200518_210527_create_events_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%events_files}}', [
            'id' => $this->primaryKey(),
            'id_event'=>$this->integer(),
            'id_event2'=>$this->integer(),
            'file_name'=>$this->text()
        ]);

        $this->addForeignKey('fk-files-id_event','events_files','id_event',
            \app\models\ProgObjectsEvents::tableName(),'id','CASCADE','CASCADE');
        $this->addForeignKey('fk-files-id_event2','events_files','id_event2',
            \app\models\ProgramObjectsEvents2::tableName(),'id','CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%events_files}}');
    }
}
