<?php

use yii\db\Migration;

/**
 * Class m200327_091359_expand_labels
 */
class m200327_091359_expand_labels extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\ObjectDocumentsTypes::tableName(),'label',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200327_091359_expand_labels cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200327_091359_expand_labels cannot be reverted.\n";

        return false;
    }
    */
}
