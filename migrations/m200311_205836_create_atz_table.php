<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atz}}`.
 */
class m200311_205836_create_atz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%atz}}', [
            'id' => $this->primaryKey(),
            'id_program'=>$this->integer(),
            'cost_b'=>$this->text(),
            'cost_v'=>$this->text(),
            'cost_o'=>$this->text(),
            'elem'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%atz}}');
    }
}
