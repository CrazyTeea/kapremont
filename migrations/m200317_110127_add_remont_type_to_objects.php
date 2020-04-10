<?php

use yii\db\Migration;

/**
 * Class m200317_110127_add_remont_type_to_objects
 */
class m200317_110127_add_remont_type_to_objects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'type_remont',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200317_110127_add_remont_type_to_objects cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200317_110127_add_remont_type_to_objects cannot be reverted.\n";

        return false;
    }
    */
}
