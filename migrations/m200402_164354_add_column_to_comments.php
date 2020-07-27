<?php

use app\models\Comments;
use app\models\User;
use yii\db\Migration;

/**
 * Class m200402_164354_add_column_to_comments
 */
class m200402_164354_add_column_to_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $adminRole = [''];

        $this->addColumn('comments', 'user_role', $this->string());

        $allComments = Comments::find()->all();

        foreach($allComments as $comment) {
            $comment->user_role = User::getRole($comment->id_user);
            $comment->save(false);
        }
        // $allComments->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comments', 'user_role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200402_164354_add_column_to_comments cannot be reverted.\n";

        return false;
    }
    */
}
