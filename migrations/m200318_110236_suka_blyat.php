<?php

use yii\db\Migration;

/**
 * Class m200318_110236_suka_blyat
 */
class m200318_110236_suka_blyat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'file_exist',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200318_110236_suka_blyat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200318_110236_suka_blyat cannot be reverted.\n";

        return false;
    }
    */
}
