<?php

use yii\db\Migration;

/**
 * Class m200408_203210_create_file_comments
 */
class m200408_203210_create_file_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file_comments', [
            'id' => $this->primaryKey(),
            'id_obj' => $this->string(),
            'id_comment' => $this->integer(),
            'file_name' => $this->string(),
            'file_ext' => $this->string(),
            'archived' => $this->boolean()
        ]);

        $this->addForeignKey('fk-file_comments-id_comment', 'file_comments', 'id_comment', 'comments', 'id');
        // $this->addForeignKey('fk-file_comments-id_obj', 'file_comments', 'id_obj', 'program_objects', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-file_comments-id_comment', 'file_comments');
        // $this->dropForeignKey('fk-file_comments-id_obj', 'file_comments');
        $this->dropTable('file_comments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200408_203210_create_file_comments cannot be reverted.\n";

        return false;
    }
    */
}
