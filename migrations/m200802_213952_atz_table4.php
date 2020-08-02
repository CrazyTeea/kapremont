<?php

use kartik\select2\ThemeClassicAsset;
use yii\db\Migration;

/**
 * Class m200802_213952_atz_table4
 */
class m200802_213952_atz_table4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('atz_table_four', [
            'id' => $this->primaryKey(),
            'stage_name' => $this->string(),
            'method' => $this->string(),
            'type_document' => $this->string(),
            'name_object' => $this->string(),
            'cost_full]' => $this->string(),
            'cost_budjet' => $this->string(),
            'cost_vb' => $this->string(),
            'number_deal' => $this->string(),
            'date_doc' => $this->date(),
            'number_deal' => $this->string(),
            'name_deller_by_doc' => $this->string(),
            'inn_deller_by_doc' => $this->string(),
            'date_start' => $this->date(),
            'date_end' => $this->date(),
            'docs' =>  $this->string(), //WTF??
            'comment_vuz' => $this->text(),
            'mon_expert' => $this->integer(),
            'comment_mon' => $this->string()
        ]);

        $this->createTable('atz_address', [
            'id' => $this->primaryKey(),
            'id_atz_table_four' => $this->integer(),
            'passport_name' => $this->string()
        ]);

        $this->createTable('atz_type_activity', [
            'id' => $this->primaryKey(),
            'id_atz_table_for_address' => $this->integer(),
            'name' => $this->string(),
            'value' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atz_table_four');
        $this->dropTable('atz_address');
        $this->dropTable('atz_type_activity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200802_213952_atz_table4 cannot be reverted.\n";

        return false;
    }
    */
}
