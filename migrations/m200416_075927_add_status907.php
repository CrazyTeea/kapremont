<?php

use yii\db\Migration;

/**
 * Class m200416_075927_add_status907
 */
class m200416_075927_add_status907 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'status907',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200416_075927_add_status907 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200416_075927_add_status907 cannot be reverted.\n";

        return false;
    }
    */
}
