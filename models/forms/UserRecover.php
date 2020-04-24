<?php


namespace app\models\forms;



use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\base\Model;
use yii\rbac\PhpManager;

class UserRecover extends Model
{
    public $username;
    public $role;
    public function rules()
    {
        return [
            [['username'],'email'],
            [['role'],'each','rule'=>['integer']]
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'Логин ИАСМОН'
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function resetFromIasmon(){
        if ($this->validate()){
            $signer = new Sha256();

            $token = (new Builder())->set('reference', 'user')
                ->sign($signer, 'example_key233')
                ->getToken();

            $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

            $signer = new Sha256();
            $token = (new Parser())->parse($response_token);
            $user = null;
            $id_org = 1;
            $pwd = 'password';
            if($token->verify($signer, 'example_key233')) {
                $data_reference = $token->getClaims();
                foreach ($data_reference as $ias_user){
                    if ($ias_user->getValue()->login == $this->username) {
                        $user = User::findOne(['username' => $this->username]);
                        $id_org = $ias_user->getValue()->podved_id;
                        $password = $ias_user->getValue()->pwd;

                        if (!$user)
                            $user = new User();
                        $user->id_org = $id_org;
                        $user->username = $this->username;
                        $user->auth_key = Yii::$app->getSecurity()->generateRandomString();
                        $user->setPassword($password);
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
                        $rbac->revokeAll($user->id);
                        $rbac->assign($rbac->getRole($role),$user->id);
                        $rbac->assign($rbac->getPermission('dev_program'),$user->id);

                        return true;
                    }
                }
            }
        }
        return false;
    }
}