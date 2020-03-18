<?php

use yii\db\Migration;

/**
 * Class m200316_201131_add_orginfo_cols
 */
class m200316_201131_add_orginfo_cols extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\OrgInfo::tableName(),'square_all',$this->decimal(22,3));
        $this->addColumn(\app\models\OrgInfo::tableName(),'square_all_kap',$this->decimal(22,3));
        $this->addColumn(\app\models\OrgInfo::tableName(),'square_all_av',$this->decimal(22,3));
        $this->addColumn(\app\models\OrgInfo::tableName(),'square_all_atz',$this->decimal(22,3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200316_201131_add_orginfo_cols cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200316_201131_add_orginfo_cols cannot be reverted.\n";

        return false;
    }
    */
}
