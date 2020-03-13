<?php

use yii\db\Migration;

/**
 * Class m200313_071921_decimal_all_cols
 */
class m200313_071921_decimal_all_cols extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\ProgObjectsEvents::tableName(),'cost_real',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgObjectsEvents::tableName(),'sum_bud_fin',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgObjectsEvents::tableName(),'fin_vnebud_ist',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'finance_sum',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'square',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'coFinancing',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'square_kap',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'isp_v_ust_dey',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'n_isp_v_ust_dey',$this->decimal(null,3));
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'square_ar',$this->decimal(null,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200313_071921_decimal_all_cols cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200313_071921_decimal_all_cols cannot be reverted.\n";

        return false;
    }
    */
}
