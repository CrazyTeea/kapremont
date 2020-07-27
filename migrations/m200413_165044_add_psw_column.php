<?php

use yii\db\Migration;

/**
 * Class m200413_165044_add_psw_column
 */
class m200413_165044_add_psw_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\User::tableName(),'psw',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_165044_add_psw_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_165044_add_psw_column cannot be reverted.\n";

        return false;
    }
    */
}
