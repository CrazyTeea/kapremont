<?php

use yii\db\Migration;

/**
 * Class m200421_192115_add_columns_to_events
 */
class m200421_192115_add_columns_to_events extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = \app\models\ProgObjectsEvents::tableName();
        $this->addColumn($table,'done',$this->boolean()->defaultValue(false));
        $this->addColumn($table,'doneExpert',$this->boolean()->defaultValue(false));
        $this->addColumn($table,'comment',$this->text());
        $this->addColumn($table,'commentExpert',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200421_192115_add_columns_to_events cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200421_192115_add_columns_to_events cannot be reverted.\n";

        return false;
    }
    */
}
