<?php

namespace app\controllers\app;

use Yii;
use app\models\ProgramObjects;
use app\models\ProgramObjectsSearch;
use app\controllers\app\AppController;
use yii\db\Transaction;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            $this->redirect(['/']);
        $model->id_program = $program->id;
        $save = true;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            $save &= $model->save();
            if ($save){
                $transaction->commit();
                return 'ok';
            }
            else {
                $transaction->rollBack();
                return Json::encode($model->getErrors());
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
