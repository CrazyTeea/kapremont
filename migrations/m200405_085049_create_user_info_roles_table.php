<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info_roles}}`.
 */
class m200405_085049_create_user_info_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_info_roles}}', [
            'id' => $this->primaryKey(),
            'role'=>$this->text()
        ]);
        $this->addForeignKey('fk-user_info-role','user_info','role','user_info_roles','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_info-role','user_info');
        $this->dropTable('{{%user_info_roles}}');
    }
}
