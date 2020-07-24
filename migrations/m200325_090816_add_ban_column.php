<?php

use yii\db\Migration;

/**
 * Class m200325_090816_add_ban_column
 */
class m200325_090816_add_ban_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Program::tableName(),'ban',$this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200325_090816_add_ban_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200325_090816_add_ban_column cannot be reverted.\n";

        return false;
    }
    */
}
