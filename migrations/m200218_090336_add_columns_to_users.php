<?php

use yii\db\Migration;

/**
 * Class m200218_090336_add_columns_to_users
 */
class m200218_090336_add_columns_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\User::tableName(),'fio',$this->text());
        $this->addColumn(\app\models\User::tableName(),'position',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200218_090336_add_columns_to_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200218_090336_add_columns_to_users cannot be reverted.\n";

        return false;
    }
    */
}
