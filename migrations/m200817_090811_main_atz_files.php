<?php

use yii\db\Migration;

/**
 * Class m200817_090811_main_atz_files
 */
class m200817_090811_main_atz_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('main_atz_files_statistics', [
           'id' => $this->primaryKey(),
           'id_org' => $this->integer(),
           'path' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('main_atz_files_statistics');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200817_090811_main_atz_files cannot be reverted.\n";

        return false;
    }
    */
}
