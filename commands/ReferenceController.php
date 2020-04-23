<?php


namespace app\commands;

use app\models\Founders;
use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\Regions;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Yii;
use yii\console\Controller;
use yii\rbac\PhpManager;


class ReferenceController extends Controller
{
    static $jwt_key = 'example_key233';

    public function actionLL(){
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
        }else {echo "с токеном хуйня"; return  false;}
        return true;
    }
    public function actionStatus907(){
        $ids = [16,
            2,
            6,
            8,
            12,
            17,
            26,
            33,
            41,
            51,
            80,
            87,
            93,
            466,
            115,
            119,
            123,
            129,
            135,
            138,
            146,
            158,
            159,
            150,
            210,
            214,
            221,
            228,
            240,
            243,
            245,
            237,
            249];

        $programs = Program::findAll(['id_org'=>$ids]);
        foreach ($programs as $program) {
            $program->status907 = 1;
            $program->save(false);
        }
        $program_objects = ProgramObjects::findAll(['id_org'=>$ids]);
        foreach ($program_objects as $object){
            $object->system_status = 0;
            $object->save(false);
        }

    }


    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(){
        $transaction = Yii::$app->db->beginTransaction();
        if ($this->actionOrgs() and $this->actionRegions() and $this->actionFounders() and $this->actionLL()) {
            $transaction->commit();
            return "success";
        }
        $transaction->rollBack();
        return "error";
    }
    public function actionOrgs(){
        echo "Выполняется синхронизация организаций\n";

        $signer = new Sha256();
        $key = new Key( self::$jwt_key );
        $token = ( new Builder() )->withClaim( 'reference', 'organization' )
            // ->sign($signer, self::$jwt_key)
            ->getToken( $signer, $key );
        $response_token = file_get_contents( "http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token" );
        $signer = new Sha256();
        $token = ( new Parser() )->parse( $response_token );
        if ( $token->verify( $signer, self::$jwt_key ) ) {
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key => $data) {
                $row_org = Organizations::findOne( $data->getValue()->id );
                if (!$row_org) {
                    $row_org = new Organizations();
                    $row_org->id = $data->getValue()->id;
                }
                $row_org->full_name = htmlspecialchars_decode( $data->getValue()->fullname );
                $row_org->short_name = htmlspecialchars_decode( $data->getValue()->shot_name );
                $row_org->name = htmlspecialchars_decode( $data->getValue()->name );
                $row_org->id_region = ($data->getValue()->region_id != 0)?$data->getValue()->region_id:87;
                $row_org->save();

            }
            return true;
        } else
            return false;

    }
    public function actionRegions(){
        echo "Выполняется синхронизация регионов\n";
        $timestart = time();
        $err = 0;

        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'region')
            ->sign($signer, self::$jwt_key)
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if($token->verify($signer, self::$jwt_key)){

            $data_reference = $token->getClaims();

            foreach ($data_reference AS $key=>$data){
                $region = Regions::findOne(['id'=>$data->getValue()->id]);
                if (!$region){
                    $region = new Regions();
                    $region->id=$data->getValue()->id;
                }
                $region->region = $data->getValue()->name;
                if(!$region->save()){
                    $err++;
                }
            }

            if($err>0){
                return false;
            }else{
                return true;
            }

        }else{
            return false;
        }

    }
    public function actionFounders(){
        echo "Выполняется синхронизация фаундеров\n";

        $csvP = Yii::getAlias( '@webroot' ) . "/parce/founders.csv";

        $csv = fopen( $csvP, 'r' );
        $err = 0;
        while (( $row = fgetcsv( $csv, 3463, ';' ) ) != false) {
            $founder = Founders::findOne($row[2]);

            if (!$founder){
                $founder = new Founders();
                $founder->id = $row[2];
            }
            $founder->name = $row[3];
            if (!$founder->save()){
                $err++;
                print_r($founder->getErrors());
            }
            $org = Organizations::findOne($row[0]);
            if ($org){
                $org->id_founder = $row[2];
                if (!$org->save()){
                    $err++;
                    print_r($org->errors);
                }
            }
        }
        if ($err>0)
            return false;
        return true;

    }


}