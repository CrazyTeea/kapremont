<?php

use yii\db\Migration;

/**
 * Class m200325_114651_add_column_to_comments
 */
class m200325_114651_add_column_to_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comments', 'created_at','datetime DEFAULT NOW()'); //->notNull()->defaultValue();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comments', 'created_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200325_114651_add_column_to_comments cannot be reverted.\n";

        return false;
    }
    */
}
