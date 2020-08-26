<?php


namespace app\models;



use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\base\Model;
use yii\rbac\PhpManager;

class ChangePasswordForm extends Model
{
    public $username;
    public $password;
    public function rules()
    {
        return [
            [['password','username'],'string'],
            [['password'],'required']
        ];
    }
    public function attributeLabels()
    {
        return [
          'password'=>'новый пароль',
          'username'=>'логин'
        ];
    }
    public function change_password()
    {
        if (!$this->validate())
            return -1;


        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $ias_user = null;
        if($token->verify($signer, 'example_key233')){
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key=>$data){
                if ($data->getValue()->login == $this->username){
                    $ias_user = $data;
                    break;
                }
            }
        }
        $user = User::findOne(['username'=>$this->username]);
        $flag = false;
        if (!$user) {
            $user= new User();
            $user->username = $ias_user ? $ias_user->getValue()->login : $this->username;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->fio = $ias_user ? $ias_user->getValue()->name : '';
            $user->id_org = $ias_user->getValue()->podved_id;
            $user->created_at = time();
            $flag = $user->isNewRecord;
        }
        $user->setPassword($ias_user ? $ias_user->getValue()->pwd : $this->password);
        $user->updated_at = time();
        if ($user->save()) {
            if ($flag){
                $rbac = new PhpManager();
                $rbac->revokeAll($user->id);
                $rbac->assign($rbac->getRole('user'),$user->id);
            }
            return 1;
        }
        return -1;
    }
}