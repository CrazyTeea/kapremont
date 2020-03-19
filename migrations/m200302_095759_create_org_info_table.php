<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%org_info}}`.
 */
class m200302_095759_create_org_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%org_info}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'st_sr_count'=>$this->integer(),
            'st_fed_count'=>$this->integer(),
            'st_dog_count'=>$this->integer(),
            'st_in_count'=>$this->integer(),
            'prof_count'=>$this->integer(),
            'st_all'=>$this->integer(),
            'st_sr_pr_count'=>$this->integer(),
            'st_bak_count'=>$this->integer(),
            'st_spec_count'=>$this->integer(),
            'st_mag_count'=>$this->integer(),
            'st_asp_count'=>$this->integer(),
            'rab_count'=>$this->integer(),
            'nauch_rab'=>$this->integer(),
            'prof_prep_count'=>$this->integer(),
            'in_kat_rab'=>$this->integer(),
            'invalid_count'=>$this->integer(),
            'zdan_count'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%org_info}}');
    }
}
