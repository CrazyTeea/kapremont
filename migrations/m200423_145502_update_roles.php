<?php

use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use yii\db\Migration;
use yii\rbac\PhpManager;

/**
 * Class m200423_145502_update_roles
 */
class m200423_145502_update_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200423_145502_update_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200423_145502_update_roles cannot be reverted.\n";

        return false;
    }
    */
}
