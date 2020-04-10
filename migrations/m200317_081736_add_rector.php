<?php

use yii\db\Migration;

/**
 * Class m200317_081736_add_rector
 */
class m200317_081736_add_rector extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\OrgInfo::tableName(),'rector',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200317_081736_add_rector cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200317_081736_add_rector cannot be reverted.\n";

        return false;
    }
    */
}
