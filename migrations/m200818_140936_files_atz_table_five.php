<?php

use yii\db\Migration;

/**
 * Class m200818_140936_files_atz_table_five
 */
class m200818_140936_files_atz_table_five extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files_atz_table_five', [
            'id' => $this->primaryKey(),
            'id_atz' => $this->integer(),
            'id_card' => $this->integer(),
            'file_name' => $this->string(),
            'description' => $this->text(),
            'path' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropTable('files_atz_table_five');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200818_140936_files_atz_table_five cannot be reverted.\n";

        return false;
    }
    */
}
