<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pro_objects_necessary}}`.
 */
class m200304_123855_create_pro_objects_necessary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pro_objects_necessary}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer()->notNull(),
            'nalichie'=>$this->boolean(),
            'material'=>$this->string(),
            'srok_eks'=>$this->string(),
            'kap_remont'=>$this->boolean(),
            'obosnovanie'=>$this->string(),
            'system_status'=>$this->boolean()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pro_objects_necessary}}');
    }
}
