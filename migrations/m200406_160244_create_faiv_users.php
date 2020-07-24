<?php

use yii\db\Migration;

/**
 * Class m200406_160244_create_faiv_users
 */
class m200406_160244_create_faiv_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('faiv_users', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'id_founder' => $this->integer()
        ]);

        $this->addForeignKey('fk-faiv_users-id_user', 'faiv_users', 'id_user', 'user', 'id');
        $this->addForeignKey('fk-faiv_users-id_founder', 'faiv_users', 'id_founder', 'founders', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-faiv_users-id_user', 'faiv_users');
        $this->dropForeignKey('fk-faiv_users-id_founder', 'faiv_users');

        $this->dropTable('faiv_users');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200406_160244_create_faiv_users cannot be reverted.\n";

        return false;
    }
    */
}
