<?php

use yii\db\Migration;

/**
 * Class m200223_140400_change_progam_mi_bd_key
 */
class m200223_140400_change_progam_mi_bd_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\Program::tableName(),'finance_volume',$this->float());
        $this->alterColumn(\app\models\Program::tableName(),'finance_events',$this->float());
        $this->alterColumn(\app\models\Program::tableName(),'cost',$this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200223_140400_change_progam_mi_bd_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200223_140400_change_progam_mi_bd_key cannot be reverted.\n";

        return false;
    }
    */
}
