<?php


namespace app\commands;

use app\models\Organizations;
use app\models\Regions;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use yii\console\Controller;


class ReferenceController extends Controller
{
    static $jwt_key = 'example_key233';
    public function actionIndex(){
        if ($this->actionOrgs() and $this->actionRegions())
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
                $row_org->id_region = ($data->getValue()->region_id!="")?$data->getValue()->region_id:87;
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


}