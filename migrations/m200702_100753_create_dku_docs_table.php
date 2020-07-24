<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dku_docs}}`.
 */
class m200702_100753_create_dku_docs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dku_docs}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'file_name'=>$this->text(),
        ]);

        $this->addForeignKey('fk-dku_docs_organization','dku_docs','id_org','organizations','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dku_docs}}');
    }
}
