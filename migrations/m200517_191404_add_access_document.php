<?php

use yii\db\Migration;

/**
 * Class m200517_191404_add_access_document
 */
class m200517_191404_add_access_document extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgObjectsEvents::tableName(),'access_document',$this->text());
        $this->addColumn(\app\models\ProgramObjectsEvents2::tableName(),'access_document',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200517_191404_add_access_document cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200517_191404_add_access_document cannot be reverted.\n";

        return false;
    }
    */
}
