<?php

use yii\db\Migration;

/**
 * Class m200629_121915_add_id_founder_to_users
 */
class m200629_121915_add_id_founder_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\User::tableName(),'id_founder',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200629_121915_add_id_founder_to_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200629_121915_add_id_founder_to_users cannot be reverted.\n";

        return false;
    }
    */
}
