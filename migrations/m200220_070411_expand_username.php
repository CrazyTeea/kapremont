<?php

use yii\db\Migration;

/**
 * Class m200220_070411_expand_username
 */
class m200220_070411_expand_username extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\User::tableName(),'username',$this->string(1000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_070411_expand_username cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_070411_expand_username cannot be reverted.\n";

        return false;
    }
    */
}
