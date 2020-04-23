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
        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $user = null;
        if($token->verify($signer, 'example_key233')) {
            $data_reference = $token->getClaims();
            foreach ($data_reference as $ias_user){
                $user = User::findOne(['username' => $ias_user->getValue()->login]);

                if (!$user)
                    $user = new User();
                $user->id_org = $ias_user->getValue()->podved_id;;
                $user->username = $ias_user->getValue()->login;
                $user->auth_key = Yii::$app->getSecurity()->generateRandomString();
                $user->setPassword($ias_user->getValue()->pwd);
                $user->status = 10;
                $user->save(false);

                $rbac = new PhpManager();
                $role = 'user';
                switch ($ias_user->getValue()->access){
                    case 'user':
                    case 'podved':
                    case 'other_podved':{
                        $role = 'user';
                        break;
                    }
                    case 'admin':{
                        $role='root';
                    }
                }
                print_r($user->username);

                echo " ";
                $rbac->revokeAll($user->id);
                $rbac->assign($rbac->getRole($role),$user->id);
                $rbac->assign($rbac->getPermission('dev_program'),$user->id);
                print_r($role);
                echo "\n";
                //ss
            }
        }
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
