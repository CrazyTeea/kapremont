<?php

use yii\db\Migration;

/**
 * Class m200516_215755_add_real_status
 */
class m200516_215755_add_real_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'real_status',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200516_215755_add_real_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200516_215755_add_real_status cannot be reverted.\n";

        return false;
    }
    */
}
