<?php

use yii\db\Migration;

/**
 * Class m200305_120033_add_column_to_riscs
 */
class m200305_120033_add_column_to_riscs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgObjectsRiscs::tableName(),'id_object',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200305_120033_add_column_to_riscs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200305_120033_add_column_to_riscs cannot be reverted.\n";

        return false;
    }
    */
}
