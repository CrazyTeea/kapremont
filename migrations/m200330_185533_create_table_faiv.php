<?php

use yii\db\Migration;

/**
 * Class m200330_185533_create_table_faiv
 */
class m200330_185533_create_table_faiv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('faiv', [
            'id' => $this->primaryKey(),
            'id_faiv_user' => $this->integer(),
            'id_faiv_admin' => $this->integer(),
            'id_org' => $this->integer()
        ]);

        $this->addForeignKey('fk-faiv-id_faiv_user', 'faiv', 'id_faiv_user', 'user','id');
        $this->addForeignKey('fk-faiv-id_faiv_admin', 'faiv', 'id_faiv_admin', 'user', 'id');
        $this->addForeignKey('fk-faiv-id_org', 'faiv', 'id_org', 'organizations', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-faiv-id_faiv_user', 'faiv');
        $this->dropForeignKey('fk-faiv-id_faiv_admin', 'faiv');
        $this->dropForeignKey('fk-faiv-id_org', 'faiv');

        $this->dropTable('faiv');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200330_185533_create_table_faiv cannot be reverted.\n";

        return false;
    }
    */
}
