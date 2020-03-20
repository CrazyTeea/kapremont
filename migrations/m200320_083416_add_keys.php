<?php

use yii\db\Migration;

/**
 * Class m200320_083416_add_keys
 */
class m200320_083416_add_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-pro_objects_necessary-id_object',\app\models\ProObjectsNecessary::tableName(),['id_object'],\app\models\ProgramObjects::tableName(),['id'],'CASCADE');
        $this->addForeignKey('fk-prog_objects_waites-id_object',\app\models\ProgObjectsWaites::tableName(),['id_object'],\app\models\ProgramObjects::tableName(),['id'],'CASCADE');
        $this->addForeignKey('fk-prog_objects_events-id_object',\app\models\ProgObjectsEvents::tableName(),['id_object'],\app\models\ProgramObjects::tableName(),['id'],'CASCADE');
        $this->addForeignKey('fk-prog_objects_riscs-id_object',\app\models\ProgObjectsRiscs::tableName(),['id_object'],\app\models\ProgramObjects::tableName(),['id'],'CASCADE');
        $this->addForeignKey('fk-object_documents_list-id_object',\app\models\ObjectDocumentsList::tableName(),['id_object'],\app\models\ProgramObjects::tableName(),['id'],'CASCADE');
        $this->addForeignKey('fk-object_documents_list-id_file',\app\models\ObjectDocumentsList::tableName(),['id_file'],\app\models\Files::tableName(),['id'],'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200320_083416_add_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200320_083416_add_keys cannot be reverted.\n";

        return false;
    }
    */
}
