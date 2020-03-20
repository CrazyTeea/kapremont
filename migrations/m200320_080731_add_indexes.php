<?php

use yii\db\Migration;

/**
 * Class m200320_080731_add_indexes
 */
class m200320_080731_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('I-pro-objects-necessary-id_object',\app\models\ProObjectsNecessary::tableName(),['id_object']);
        $this->createIndex('I-prog-objects-waites-id_object',\app\models\ProgObjectsWaites::tableName(),['id_object']);
        $this->createIndex('I-prog-objects-events-id_object',\app\models\ProgObjectsEvents::tableName(),['id_object']);
        $this->createIndex('I-prog-objects-riscs-id_object',\app\models\ProgObjectsRiscs::tableName(),['id_object']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200320_080731_add_indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200320_080731_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
