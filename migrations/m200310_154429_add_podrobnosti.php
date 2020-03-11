<?php

use yii\db\Migration;

/**
 * Class m200310_154429_add_podrobnosti
 */
class m200310_154429_add_podrobnosti extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'podrobnosti',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_154429_add_podrobnosti cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200310_154429_add_podrobnosti cannot be reverted.\n";

        return false;
    }
    */
}
