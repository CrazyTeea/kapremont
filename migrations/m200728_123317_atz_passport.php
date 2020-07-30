<?php

use app\models\AntiterrorPassport;
use yii\db\Migration;

/**
 * Class m200728_123317_atz_passport
 */
class m200728_123317_atz_passport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('atz_passport', [
            'id' => $this->primaryKey(),
            'id_org' => $this->integer(),
            'name_address' => $this->string(2000),
            'old_ids' => $this->string(1000)
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atz_passport');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_123317_atz_passport cannot be reverted.\n";

        return false;
    }
    */
}
