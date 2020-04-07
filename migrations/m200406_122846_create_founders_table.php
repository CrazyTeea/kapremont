<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%founders}}`.
 */
class m200406_122846_create_founders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%founders}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->text()
        ]);
        $this->addColumn(\app\models\Organizations::tableName(),'id_founder',$this->integer());
        $this->addForeignKey('fk-organizations-id_founder',\app\models\Organizations::tableName(),['id_founder'],\app\models\Founders::tableName(),['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-organizations-id_founder',\app\models\Organizations::tableName());
        $this->dropColumn('id_founder',\app\models\Organizations::tableName());
        $this->dropTable('{{%founders}}');
    }
}
