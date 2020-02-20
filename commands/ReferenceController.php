<?php


namespace app\commands;

use app\models\app\students\Students;
use app\models\Organizations;
use app\models\Program;
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
    public function actionIndex(){
        if ($this->actionOrgs() and $this->actionRegions() and $this->actionUsers())
            return "success";
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
                if ( empty( $row_org ) ) {
                    $row_org = new Organizations();
                    $row_org->id = $data->getValue()->id;
                }
                $row_org->full_name = htmlspecialchars_decode( $data->getValue()->fullname );
                $row_org->short_name = htmlspecialchars_decode( $data->getValue()->shot_name );
                $row_org->name = htmlspecialchars_decode( $data->getValue()->name );
                $row_org->id_region = ($data->getValue()->region_id!="")?$data->getValue()->region_id:0;
                $row_org->save();

            }
            return true;
        } else
            return false;

    }
    public function actionRegions(){
        echo "Выполняется синхронизация регионов";
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
    public function actionUsers(){
        echo "Выполняется синхронизация пользователей\n";
        $timestart = time();
        $err = 0;
        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'user')
            ->sign($signer, self::$jwt_key)
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if($token->verify($signer, self::$jwt_key)){
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key=>$data){

                $row_user = User::findOne(["username"=>$data->getValue()->login]);

                if(!$row_user) {
                    $row_user = new User();
                    $row_user->created_at = time();
                }
                $row_user->username = $data->getValue()->login;
                $row_user->auth_key = Yii::$app->security->generateRandomString();
                $row_user->password_hash = Yii::$app->security->generatePasswordHash($data->getValue()->pwd,4);
                $row_user->fio = $data->getValue()->name;
                $row_user->updated_at = time();
               // $data->getValue()->position;
                //$row_user->position = $data->getValue()->position;
                $row_user->id_org = ($data->getValue()->podved_id!="")?$data->getValue()->podved_id:NULL;
                $str = ($row_user->isNewRecord) ? 'добавление' : 'обновление';
                if(!$row_user->save()){
                    $err++;

                }
                $role = new PhpManager();

                $role->revokeAll($row_user->id);
                $role->assign($role->getRole('root'),$row_user->id);

            }

            if($err>0){
                return false;
            }else {
                return true;
            }
        }else{
            return false;
        }

    }
    public function actionProgram($file,$org,$fin,$ev,$cost){
        $csvP = Yii::getAlias( '@webroot' ) . "/parce/$file.csv";

        $csv = fopen( $csvP, 'r' );
        if ( !$csvP )
            exit( "Файл не найден" );

        $row = fgetcsv( $csv, 1000, ';' ) ;

        echo "
            Организация->$row[$org]
            фин->$row[$fin]
            евент->$row[$ev]
            цена->$row[$cost]";


        fclose( $csv );
        $csv = fopen( $csvP, 'r' );
        echo "Вы уверене? \n ";
        $key = readline();
        if ( !( $key === "yes" || $key === "y" || $key === "Y" ) ) {
            exit( 0 );
        }
        echo "fdsfsd";


        while (( $row = fgetcsv( $csv, 1000, ';' ) ) != false) {

            $program = Program::findOne(['id_org'=>$row[$org],'finance_volume'=>$row[$fin],'finance_events'=>$row[$ev],'cost'=>$row[$cost]]);
            if (!$program) {
                $program = new Program();
            }
            $program->id_org=$row[$org];
            $program->cost = $row[$cost];
            $program->finance_events = $row[$ev];
            $program->finance_volume = $row[$fin];


            if ( $program->save(false) ) {

                echo "
            Организация-> $program->id_org
            фин->$program->finance_volume
            евент->$program->finance_events
            цена->$program->cost \n";
            }

        }
        fclose( $csv );
        echo "success!";
    }
}