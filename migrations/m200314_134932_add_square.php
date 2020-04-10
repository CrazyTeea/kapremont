<?php

use yii\db\Migration;

/**
 * Class m200314_134932_add_square
 */
class m200314_134932_add_square extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\ProgramObjects::tableName(),'square_atz',$this->decimal(22,3));
        $this->addColumn(\app\models\ProgramObjects::tableName(),'square_av',$this->decimal(22,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200314_134932_add_square cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200314_134932_add_square cannot be reverted.\n";

        return false;
    }
    */
}
