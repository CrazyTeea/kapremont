<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atz_files}}`.
 */
class m201028_182123_create_atz_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%atz_files}}', [
            'id' => $this->primaryKey(),
            'file'=>$this->text(),
            'id_atz'=>$this->integer(),
            'id_org'=>$this->integer(),
            'type'=>$this->integer()
        ]);

        $this->addForeignKey('fk-atz_files-id_atz','atz_files','id_atz','atz','id','CASCADE');
        $this->addForeignKey('fk-atz_files-id_org','atz_files','id_org','organizations','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%atz_files}}');
    }
}
