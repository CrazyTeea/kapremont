<?php

use yii\db\Migration;

/**
 * Class m201103_133115_add_col
 */
class m201103_133115_add_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\AtzTable4Files::tableName(),'id_tab4',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201103_133115_add_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201103_133115_add_col cannot be reverted.\n";

        return false;
    }
    */
}
