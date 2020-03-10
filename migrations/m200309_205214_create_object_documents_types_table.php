<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_documents_types}}`.
 */
class m200309_205214_create_object_documents_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_documents_types}}', [
            'id' => $this->primaryKey(),
            'descriptor'=>$this->string()->notNull(),
            'label'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%object_documents_types}}');
    }
}
