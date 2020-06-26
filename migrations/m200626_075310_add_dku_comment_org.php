<?php

use yii\db\Migration;

/**
 * Class m200626_075310_add_dku_comment_org
 */
class m200626_075310_add_dku_comment_org extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(),'dku_comment',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200626_075310_add_dku_comment_org cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200626_075310_add_dku_comment_org cannot be reverted.\n";

        return false;
    }
    */
}
