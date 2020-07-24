<?php

use yii\db\Migration;

/**
 * Class m200227_131001_add_objects_fields
 */
class m200227_131001_add_objects_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'id_region',$this->integer());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'id_city',$this->integer());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'address',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200227_131001_add_objects_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200227_131001_add_objects_fields cannot be reverted.\n";

        return false;
    }
    */
}
