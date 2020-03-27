<?php

use app\models\ApproveStatus;
use app\models\ProgramObjects;
use yii\db\Migration;

/**
 * Class m200327_104604_create_approval_status
 */
class m200327_104604_create_approval_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('approve_status',[
            'id' => $this->primaryKey(),
            'status' => $this->string(),
            'label' => $this->string()
        ]);


        $statuses = [
            'not_send' => 'В обработке', 
            'recomend' => 'Рекомендуется к согласованию',
            'not_recomend' => 'Не рекомендуется к согласованию',
            'to_work' => 'Возвращено на доработку'
        ];
        foreach($statuses as $status => $label) {
            $aStatus = new ApproveStatus();
            $aStatus->status = $status;
            $aStatus->label = $label;
            $aStatus->save();
        }

        ProgramObjects::updateAll(['status' => 1]);

        //$this->addForeignKey('fk-program_objects-status', 'program_objects', 'status', 'approve_status', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->dropForeignKey('fk-program_objects-status', 'program_objects');

        $this->dropTable('approve_status');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200327_104604_create_approval_status cannot be reverted.\n";

        return false;
    }
    */
}
