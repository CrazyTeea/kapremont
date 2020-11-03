<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atz_table4_files}}`.
 */
class m201103_130900_create_atz_table4_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%atz_table4_files}}', [
            'id' => $this->primaryKey(),
            'file'=>$this->text(),
            'id_org'=>$this->integer(),
            'type'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%atz_table4_files}}');
    }
}
