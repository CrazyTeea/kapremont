<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\ObjectDocumentsList;
use app\models\ObjectDocumentsTypes;
use app\models\Organizations;
use app\models\ProgObjectsEvents;
use app\models\ProgObjectsRiscs;
use app\models\ProgObjectsWaites;
use app\models\ProgramObjects;
use app\models\ProObjectsNecessary;
use Mpdf\Gif\FileHeader;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Yii;

use yii\base\Exception;
use yii\base\InvalidConfigException;

use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * DevelopmentProgrammeController implements the CRUD actions for DevelopmentProgramme model.
 */
class DevelopmentProgrammeController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAddDoc($id)
    {
        $file = UploadedFile::getInstanceByName('progFile');
        if ($file) {
            $path = Yii::getAlias('@webroot') . "/uploads/programDocs";
            if (!file_exists($path))
                FileHelper::createDirectory($path);
            $file->saveAs("$path/$id.pdf");
            return 1;
        }
        return 0;
    }

    public function actionDeleteDoc($id)
    {
        $path = Yii::getAlias('@webroot') . "/uploads/programDocs/$id.pdf";
        if (file_exists($path)) {
            unlink($path);
            return 1;
        }
        return 0;
    }

    public function actionCheckDoc($id)
    {
        $path = Yii::getAlias('@webroot') . "/uploads/programDocs/$id.pdf";
        return json_encode(file_exists($path));
    }

    public function actionDownloadDoc($id)
    {
        $path = Yii::getAlias('@webroot') . "/uploads/programDocs/$id.pdf";
        if(file_exists($path)){
            return Yii::$app->response->sendFile($path)->send();
        }
         
        return 'Такого файла еще не существует';
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     * @throws MpdfException
     */
    public function actionExport()
    {

        $user = Yii::$app->getSession()->get('user');
        $org = Organizations::findOne($user->id_org);

        $pr_ob = ProgramObjects::findAll(['system_status'=>1,'id_org'=>$user->id_org,'type'=>0]);
        $r_ob = ProgramObjects::findAll(['system_status'=>1,'id_org'=>$user->id_org,'type'=>1]);
        $sq =[
        's_k' => ProgramObjects::find()->select(['square'])->where(['system_status'=>1,'id_org'=>$org->id,])->sum('square'),
        's_k_s' => ProgramObjects::find()->select(['square_kap'])->where(['system_status'=>1,'id_org'=>$org->id,])->sum('square_kap'),
        's_av' => ProgramObjects::find()->select(['square_ar'])->where(['system_status'=>1,'id_org'=>$org->id,])->sum('square_av'),
        's_atz' => ProgramObjects::find()->select(['square_ar'])->where(['system_status'=>1,'id_org'=>$org->id,])->sum('square_av'),
        ];
        $pr_cols = ProgramObjects::getTableSchema()->getColumnNames();
        $program = Yii::$app->getSession()->get('program');
        if (!$program)
            return $this->redirect(['/']);
        $atz = Atz::findAll(['id_program'=>$program->id]);
        $atzC = [];
        $bC = $vC = $bvC = 0;
        foreach ($atz as $item){
            $bC  += floatval($item->cost_b);
            $vC  += floatval($item->cost_v);
            $bvC += (floatval($item->cost_v) + floatval($item->cost_b));
            $atzC = [
                'bC' =>number_format($bC, 0, ',', ' '),
                'vC' =>number_format($vC, 0, ',', ' '),
                'bvC' =>number_format($bvC, 0, ',', ' ')
            ];
        }

        // echo"<pre>";
        // print_r($atzC);



        $objects = ProgramObjects::findAll(['system_status'=>1,'id_program'=>$program->id]);
        $events = null;$nes = null;$wai = null;;$risks = null;
        foreach ($objects as $index=>$item) {
            for ($i = 0;$i<8;$i++){
                $events[$index][$i]=ProgObjectsEvents::findOne(['id_object'=>$item->id,'step'=>$i]);
            }
            for ($i = 0;$i<34;$i++){
                $nes[$index][$i]=ProObjectsNecessary::findOne(['id_object'=>$item->id,'element'=>$i]);
            }
            $wai[$index]=ProgObjectsWaites::findAll(['id_object'=>$item->id]);
            $risks[$index]=ProgObjectsRiscs::findAll(['id_object'=>$item->id]);
        }


        // $mpdf = new Mpdf();
        // $stylesheet = file_get_contents('bootstrap/css/bootstrap.css');
        // $stylesheet2 = file_get_contents('bootstrap/css/bootstrap-grid.css');
        // ini_set("pcre.backtrack_limit", "5000000");
        // $mpdf->WriteHTML($stylesheet,HTMLParserMode::HEADER_CSS);
        // $mpdf->WriteHTML($stylesheet2,HTMLParserMode::HEADER_CSS);
        // $mpdf->WriteHTML($this->renderPartial('_export',compact('objects','org','atz','pr_ob','r_ob','events','nes','wai','risks','sq','atzC')));
        // $mpdf->Output();
    }

    /**
     * Lists all DevelopmentProgramme models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new DevelopmentProgrammeSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index');
    }

}
