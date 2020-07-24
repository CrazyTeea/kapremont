<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m200324_124322_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'id_obj' => $this->integer()->notNull(),
            'message' => $this->text(),
            'id_user' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk-comments-id_obj', 'comments', 'id_obj', 'program_objects', 'id');
        $this->addForeignKey('fk-comments-id_user', 'comments', 'id_user', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');

        $this->dropForeignKey('fk-comments-id_obj', 'comments');
        $this->dropForeignKey('fk-comments-id_user', 'comments');
    }
}
