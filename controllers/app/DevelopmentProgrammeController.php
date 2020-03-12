<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\ProgramObjects;
use DOMDocument;
use Dompdf\Dompdf;
use HTMLtoOpenXML\Parser;
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
     */
    public function actionExport(){


        $file = new TemplateProcessor('templates/export.docx');
        $user = Yii::$app->getSession()->get('user');
        $org = Organizations::findOne($user->id_org);
        $file->setValue('org_full',$org ? $org->full_name : '');
        $file->setValue('org_short',$org ? $org->short_name : '');
        foreach (OrgInfo::getTableSchema()->getColumnNames() as $column){
            if ($column == 'id_org') continue;
            $file->setValue($column,$org ? $org->orgInfo ? $org->orgInfo->{$column} : 0 : 0);
        }
        $pr_ob = ProgramObjects::findAll(['id_org'=>$user->id_org,'type'=>0]);
        $pr_cols = ProgramObjects::getTableSchema()->getColumnNames();
        $program = Yii::$app->getSession()->get('program');
        $atz = Atz::findAll(['id_program'=>$program->id]);
        for($i=0;$i<9;$i++){
            if (ArrayHelper::keyExists($i,$atz)) {
                $file->setValue("cost_b_$i", $atz[$i]->cost_b);
                $file->setValue("cost_v_$i", $atz[$i]->cost_v);
                $file->setValue("cost_o_$i", intval($atz[$i]->cost_v) +intval( $atz[$i]->cost_b));
            }
            else{
                $file->setValue("cost_b_$i", 0);
                $file->setValue("cost_v_$i", 0);
                $file->setValue("cost_o_$i", 0);
            }
        }




        $file->cloneRow("pr_id",count($pr_ob));

        $prior = [
            '1',
            '2',
            '3',
            'резерв'
        ];

        foreach ($pr_ob as $index => $object){
            $i = $index+1;
            foreach ($pr_cols as $col) {
                if ($col == 'id_org') continue;
                if ($col=='id_region')
                    $file->setValue("pr_region#{$i}", $object->region ? $object->region->region : '');
                if ($col=='id_priority')
                    $file->setValue("pr_priority#{$i}", !is_null($object->id_priority) ? $prior[$object->id_priority] : '');
                $file->setValue("pr_{$col}#{$i}", $object->{$col});
            }
        }
        

        $r_ob = ProgramObjects::findAll(['id_org'=>$user->id_org,'type'=>1]);

        $file->cloneRow("r_id",count($r_ob));

        foreach ($r_ob as $index => $object){
            $i = $index+1;
            foreach ($pr_cols as $col) {
                if ($col == 'id_org') continue;
                if ($col=='id_region')
                    $file->setValue("r_region#{$i}", $object->region ? $object->region->region : '');
                if ($col=='id_priority')
                    $file->setValue("r_priority#{$i}", !is_null($object->id_priority) ? $prior[$object->id_priority] : '');
                $file->setValue("r_{$col}#{$i}", $object->{$col});
            }
        }

        $path = Yii::getAlias( '@webroot' ) . '/uploads/'.$user->id_org ? : $user->id;
        if ( !file_exists( $path ) )
            FileHelper::createDirectory( $path );
        $file->saveAs("$path/temp.docx");
        // Make sure you have `dompdf/dompdf` in your composer dependencies.
        Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
        // Any writable directory here. It will be ignored.
        Settings::setPdfRendererPath('.');
        $phpWord = IOFactory::load("$path/temp.docx", 'Word2007');

        $phpWord->save("$path/document.pdf", 'PDF');

        return Yii::$app->response->sendFile("$path/document.pdf")->send();

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
