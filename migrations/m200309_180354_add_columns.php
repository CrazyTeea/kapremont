<?php

use yii\db\Migration;

/**
 * Class m200309_180334_add_columns
 */
class m200309_180354_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgObjectsRiscs::tableName(),'element',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_180334_add_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_180334_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
