<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\ProgObjectsEvents;
use app\models\ProgObjectsRiscs;
use app\models\ProgObjectsWaites;
use app\models\ProgramObjects;

use app\models\ProObjectsNecessary;
use Dompdf\Dompdf;
use HTMLtoOpenXML\Parser;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\shared\HTML;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

use Yii;
use app\models\DevelopmentProgramme;

use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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

    /**
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \Mpdf\MpdfException
     */
    public function actionExport(){

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
                'bC' =>$bC,
                'vC' =>$vC,
                'bvC' =>$bvC
            ];
        }




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


        $mpdf = new Mpdf();
        $stylesheet = file_get_contents('bootstrap/css/bootstrap.css');
        $stylesheet2 = file_get_contents('bootstrap/css/bootstrap-grid.css');
        ini_set("pcre.backtrack_limit", "5000000");
        $mpdf->WriteHTML($stylesheet,HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($stylesheet2,HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($this->renderPartial('_export',compact('objects','org','atz','pr_ob','r_ob','events','nes','wai','risks','sq','atzC')));
        $mpdf->Output();
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

    /**
     * Displays a single DevelopmentProgramme model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DevelopmentProgramme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DevelopmentProgramme();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DevelopmentProgramme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DevelopmentProgramme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DevelopmentProgramme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DevelopmentProgramme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DevelopmentProgramme::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
