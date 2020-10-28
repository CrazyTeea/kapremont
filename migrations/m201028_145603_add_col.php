<?php

use yii\db\Migration;

/**
 * Class m201028_145603_add_col
 */
class m201028_145603_add_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\AtzTableFour::tableName(),'zakant',$this->decimal(22,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201028_145603_add_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201028_145603_add_col cannot be reverted.\n";

        return false;
    }
    */
}
