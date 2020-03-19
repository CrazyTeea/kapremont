<?php

use yii\db\Migration;

/**
 * Class m200319_144938_rename_column
 */
class m200319_144938_rename_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(\app\models\Program::tableName(),'status','p_status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200319_144938_rename_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200319_144938_rename_column cannot be reverted.\n";

        return false;
    }
    */
}
