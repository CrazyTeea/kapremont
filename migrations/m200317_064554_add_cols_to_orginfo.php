<?php

use yii\db\Migration;

/**
 * Class m200317_064554_add_cols_to_orginfo
 */
class m200317_064554_add_cols_to_orginfo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\OrgInfo::tableName(),'aspirants',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200317_064554_add_cols_to_orginfo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200317_064554_add_cols_to_orginfo cannot be reverted.\n";

        return false;
    }
    */
}
