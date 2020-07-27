<?php

use yii\db\Migration;

/**
 * Class m200301_192812_add_objects_columns
 */
class m200301_192812_add_objects_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn(\app\models\ProgramObjects::tableName(),'isp_v_ust_dey',$this->decimal());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'n_isp_v_ust_dey',$this->decimal());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200301_192812_add_objects_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200301_192812_add_objects_columns cannot be reverted.\n";

        return false;
    }
    */
}
