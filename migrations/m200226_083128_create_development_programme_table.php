<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%development_programme}}`.
 */
class m200226_083128_create_development_programme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%development_programme}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'system_status'=>$this->integer()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%development_programme}}');
    }
}
