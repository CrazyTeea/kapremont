<?php

use yii\db\Migration;

/**
 * Class m200318_112457_suka_blyat_2
 */
class m200318_112457_suka_blyat_2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'status',$this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200318_112457_suka_blyat_2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200318_112457_suka_blyat_2 cannot be reverted.\n";

        return false;
    }
    */
}
