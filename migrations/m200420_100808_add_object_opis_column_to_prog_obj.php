<?php

use yii\db\Migration;

/**
 * Class m200420_100808_add_object_opis_column_to_prog_obj
 */
class m200420_100808_add_object_opis_column_to_prog_obj extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'object_opis',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200420_100808_add_object_opis_column_to_prog_obj cannot be reverted.\n";
        $this->dropColumn(\app\models\ProgramObjects::tableName(),'object_opis');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200420_100808_add_object_opis_column_to_prog_obj cannot be reverted.\n";

        return false;
    }
    */
}
