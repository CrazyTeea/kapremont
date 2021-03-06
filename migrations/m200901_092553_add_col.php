<?php

use yii\db\Migration;

/**
 * Class m200901_092553_add_col
 */
class m200901_092553_add_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'address',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200901_092553_add_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200901_092553_add_col cannot be reverted.\n";

        return false;
    }
    */
}
