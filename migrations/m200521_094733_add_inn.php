<?php

use yii\db\Migration;

/**
 * Class m200521_094733_add_inn
 */
class m200521_094733_add_inn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'inn',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200521_094733_add_inn cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200521_094733_add_inn cannot be reverted.\n";

        return false;
    }
    */
}
