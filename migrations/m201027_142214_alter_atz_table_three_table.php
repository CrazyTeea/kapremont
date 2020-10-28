<?php

use yii\db\Migration;

/**
 * Class m201027_142214_alter_atz_table_three_table
 */
class m201027_142214_alter_atz_table_three_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\AtzTableThree::tableName(),'video_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'video_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'evacuation_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'evacuation_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'light_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'light_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'predator_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'predator_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'alarm_warning_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'alarm_warning_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'alarm_fire_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'alarm_fire_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'phone_system_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'phone_system_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'fence_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'fence_nebud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'skud_bud',$this->text());
        $this->addColumn(\app\models\AtzTableThree::tableName(),'skud_nebud',$this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201027_142214_alter_atz_table_three_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201027_142214_alter_atz_table_three_table cannot be reverted.\n";

        return false;
    }
    */
}
