<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organizations}}`.
 */
class m200217_134354_create_organizations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organizations}}', [
            'id' => $this->primaryKey(),
            'full_name'=>$this->text(),
            'name'=>$this->text(),
            'short_name'=>$this->text(),
            'system_status'=>$this->integer()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organizations}}');
    }
}
