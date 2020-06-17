<?php

use yii\db\Migration;

/**
 * Class m200617_135418_change_dku_atz
 */
class m200617_135418_change_dku_atz extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $old_pr = \app\models\Program::find()->all();
        $this->alterColumn(\app\models\Program::tableName(),'dku_atz',$this->decimal(22,2));
        foreach ($old_pr as $item)
        {
            $pr= \app\models\Program::findOne($item->id);
            $pr->dku_atz = $item->dku_atz;
            $pr->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200617_135418_change_dku_atz cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200617_135418_change_dku_atz cannot be reverted.\n";

        return false;
    }
    */
}
