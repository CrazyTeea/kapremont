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

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(){
        $transaction = Yii::$app->db->beginTransaction();
        if ($this->actionRegions() and $this->actionOrgs()) {
            $transaction->commit();
            echo "success";exit();
        }
        $transaction->rollBack();
        echo "error";exit();
    }

    public function actionP(){
        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'users')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $ias_user = null;
        if($token->verify($signer, 'example_key233')){
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key=>$data){
                $user = User::findOne(['username'=>$data->getValue()->login]);
                if ($user){
                    $user->setPassword($data->getValue()->pwd);
                    echo "$user->username : {$data->getValue()->pwd} \n ";
                    $user->save(false);
                }
            }
        }
    }

    public function actionOrgs(){
        echo "Выполняется синхронизация организаций\n";
        $err=0;
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
                $row_org->inn = htmlspecialchars_decode( $data->getValue()->inn );
                $row_org->id_region = ($data->getValue()->region_id != 0)?$data->getValue()->region_id:86;
                if (!$row_org->save()) {
                    $err++;
                    var_dump($row_org->getErrors());
                }

            }
        } else return false;
        return !$err;

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

            return !$err;

        }else return false;
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