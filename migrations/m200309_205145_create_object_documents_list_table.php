<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_documents_list}}`.
 */
class m200309_205145_create_object_documents_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_documents_list}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer()->notNull(),
            'id_file'=>$this->integer()->notNull(),
            'id_type'=>$this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%object_documents_list}}');
    }
}
