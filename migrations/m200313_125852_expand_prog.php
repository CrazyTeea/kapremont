<?php

use yii\db\Migration;

/**
 * Class m200313_125852_expand_prog
 */
class m200313_125852_expand_prog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\ProgramObjects::tableName(),'osn_isp_zdan',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200313_125852_expand_prog cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200313_125852_expand_prog cannot be reverted.\n";

        return false;
    }
    */
}
