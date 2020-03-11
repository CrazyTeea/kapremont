<?php

use yii\db\Migration;
use app\models\ObjectDocumentsList;

/**
 * Class m200311_173552_add_system_status_to_object_doc_list
 */
class m200311_173552_add_system_status_to_object_doc_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'object_documents_list',
            'system_status',
            $this->integer(2)->defaultValue(1)
        );

        // ObjectDocumentsList::updateAll(['system_status' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object_documents_list', 'system_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200311_173552_add_system_status_to_object_doc_list cannot be reverted.\n";

        return false;
    }
    */
}
