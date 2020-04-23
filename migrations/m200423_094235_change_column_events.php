<?php

use yii\db\Migration;

/**
 * Class m200423_094235_change_column_events
 */
class m200423_094235_change_column_events extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\ProgramObjectsEvents2::tableName(),'step',$this->decimal(1,1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200423_094235_change_column_events cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200423_094235_change_column_events cannot be reverted.\n";

        return false;
    }
    */
}
