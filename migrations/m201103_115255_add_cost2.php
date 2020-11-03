<?php

use yii\db\Migration;

/**
 * Class m201103_115255_add_cost2
 */
class m201103_115255_add_cost2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'cost2',$this->decimal(22,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201103_115255_add_cost2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201103_115255_add_cost2 cannot be reverted.\n";

        return false;
    }
    */
}
