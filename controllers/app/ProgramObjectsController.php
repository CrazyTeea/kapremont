<?php

namespace app\controllers\app;

use app\models\ProgObjectsEvents;
use Yii;
use app\models\ProgramObjects;
use app\models\ProgramObjectsSearch;
use app\controllers\app\AppController;
use yii\base\Model;
use yii\db\Transaction;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use const Grpc\STATUS_CANCELLED;

/**
 * ProgramObjectsController implements the CRUD actions for ProgramObjects model.
 */
class ProgramObjectsController extends AppController
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
     * Lists all ProgramObjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single ProgramObjects model.
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
     * Creates a new ProgramObjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {

        $model = new ProgramObjects();
        $model->id_org = Yii::$app->session->get('user')->id_org;
        $program = Yii::$app->session->get('program');
        if (!$program)
            return $this->redirect(['/']);

        $model->id_program = $program->id;
        $save = true;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            $save &= $model->save();
            $errors['ProgramObjects'] = $model->getErrors();

            $_progObjEv = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['is_nessesary']);
            $_progObjEv_bd = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['begin_date']);
            $_progObjEv_fd = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['final_date']);
            $_progObjEv_cost = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['realization_cost']);
            $_progObjEv_sbf = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['kap_cost']);
            $_progObjEv_fvi = explode(',',Yii::$app->request->post()['ProgObjectsEvents']['finanse']);

            foreach ($_progObjEv as $index => $item){
                $progObjEv = new ProgObjectsEvents();
                $progObjEv->id_object = $model->id ? : null;
                $progObjEv->step = $index;
                $progObjEv->is_nessesary = $item;
                if (is_array($_progObjEv_bd) and isset($_progObjEv_bd[$index]))
                    $progObjEv->date_event_start = $_progObjEv_bd[$index];
                if (is_array($_progObjEv_bd) and isset($_progObjEv_bd[$index]))
                    $progObjEv->date_event_end = $_progObjEv_fd[$index];
                if (is_array($_progObjEv_cost) and isset($_progObjEv_cost[$index]))
                    $progObjEv->cost_real = $_progObjEv_cost[$index];
                if (is_array($_progObjEv_sbf) and isset($_progObjEv_sbf[$index]))
                    $progObjEv->sum_bud_fin = $_progObjEv_sbf[$index];
                if (is_array($_progObjEv_fvi) and isset($_progObjEv_fvi[$index]))
                    $progObjEv->fin_vnebud_ist = $_progObjEv_fvi[$index];
                $save &= $progObjEv->save();
                $errors['ProgObjectsEvents'][] = $progObjEv->getErrors();
            }

            //foreach ()


            if ($save){
                $transaction->commit();
                return 'ok';
            }
            else {
                $transaction->rollBack();
                Yii::$app->response->statusCode = 500;
                return Json::encode($errors);
            }
        }

        return $this->render('create');
    }

    /**
     * Updates an existing ProgramObjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        return $this->render('update');
    }

    /**
     * Deletes an existing ProgramObjects model.
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
     * Finds the ProgramObjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProgramObjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProgramObjects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
