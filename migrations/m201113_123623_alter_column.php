<?php

use yii\db\Migration;

/**
 * Class m201113_123623_alter_column
 */
class m201113_123623_alter_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\AtzTableFour::tableName(),'cost_full',$this->decimal(22,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201113_123623_alter_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201113_123623_alter_column cannot be reverted.\n";

        return false;
    }
    */
}
