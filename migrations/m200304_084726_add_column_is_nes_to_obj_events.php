<?php

use yii\db\Migration;

/**
 * Class m200304_084726_add_column_is_nes_to_obj_events
 */
class m200304_084726_add_column_is_nes_to_obj_events extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgObjectsEvents::tableName(),'is_nessesary',$this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200304_084726_add_column_is_nes_to_obj_events cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200304_084726_add_column_is_nes_to_obj_events cannot be reverted.\n";

        return false;
    }
    */
}
