<?php

use yii\db\Migration;

/**
 * Class m200806_110849_comments_add_columns
 */
class m200806_110849_comments_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comments', 'id_atz', $this->integer());

        $this->addColumn('file_comments', 'id_atz', $this->integer());


//        $this->dropForeignKey('fk-comments-id_obj', 'comments');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('comments', 'id_atz');

       $this->dropColumn('file_comments', 'id_atz');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200806_110849_comments_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
