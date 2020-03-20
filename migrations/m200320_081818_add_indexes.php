<?php

use yii\db\Migration;

/**
 * Class m200320_081818_add_indexes
 */
class m200320_081818_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('I-object_documents-list-id_object',\app\models\ObjectDocumentsList::tableName(),['id_object']);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200320_081818_add_indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200320_081818_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
