<?php

use yii\db\Migration;

/**
 * Class m200519_101618_fix_step
 */
class m200519_101618_fix_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\ProgramObjectsEvents2::tableName(),'step',$this->decimal(22,1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200519_101618_fix_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200519_101618_fix_step cannot be reverted.\n";

        return false;
    }
    */
}
