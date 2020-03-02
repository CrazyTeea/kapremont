<?php

use yii\db\Migration;

/**
 * Class m200301_184453_add_objects_columns
 */
class m200301_184453_add_objects_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'osn_isp_zdan',$this->string());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'prav_oper_upr',$this->string());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'prav_sob',$this->string());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'square_kap',$this->decimal());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200301_184453_add_objects_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200301_184453_add_objects_columns cannot be reverted.\n";

        return false;
    }
    */
}
