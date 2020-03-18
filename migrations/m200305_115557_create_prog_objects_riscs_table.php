<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prog_objects_riscs}}`.
 */
class m200305_115557_create_prog_objects_riscs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prog_objects_riscs}}', [
            'id' => $this->primaryKey(),
            'types'=>$this->text(),
            'poison'=>$this->text(),
            'protect'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prog_objects_riscs}}');
    }
}
