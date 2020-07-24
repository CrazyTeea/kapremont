<?php

use yii\db\Migration;

/**
 * Class m200423_120649_add_columns_to_events2
 */
class m200423_120649_add_columns_to_events2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjectsEvents2::tableName(),'id_object',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200423_120649_add_columns_to_events2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200423_120649_add_columns_to_events2 cannot be reverted.\n";

        return false;
    }
    */
}
