<?php

use yii\db\Migration;

/**
 * Class m200315_165535_add_label_doc_list
 */
class m200315_165535_add_label_doc_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ObjectDocumentsList::tableName(),'label',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200315_165535_add_label_doc_list cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200315_165535_add_label_doc_list cannot be reverted.\n";

        return false;
    }
    */
}
