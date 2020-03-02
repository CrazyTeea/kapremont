<?php

use yii\db\Migration;

/**
 * Class m200302_184634_add_prog_objs_columns
 */
class m200302_184634_add_prog_objs_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'kad_number',$this->string());
        $this->addColumn(\app\models\ProgramObjects::tableName(),'exploit_year',$this->integer());
       



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200302_184634_add_prog_objs_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200302_184634_add_prog_objs_columns cannot be reverted.\n";

        return false;
    }
    */
}
