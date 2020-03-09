<?php

namespace app\controllers\app;

use app\models\ProgObjectsEvents;
use app\models\ProgObjectsRiscs;
use app\models\ProgObjectsWaites;
use app\models\ProObjectsNecessary;
use Yii;
use app\models\ProgramObjects;
use yii\base\Model;
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
        $model = $this->findModel($id);
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
        $progObjectsEvents = [new ProgObjectsEvents()];
        $proObjectsNecessary = [new ProObjectsNecessary()];
        $progObjectsWaites = [new ProgObjectsWaites()];
        $progObjectsRiscs = [new ProgObjectsRiscs()];

        $model->id_org = Yii::$app->session->get('user')->id_org;
        $program = Yii::$app->session->get('program');
        if (!$program)
            return $this->redirect(['/']);

        $model->id_program = $program->id;
        $save = true;
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                $transaction = Yii::$app->getDb()->beginTransaction();
                $save &= $model->save();


                $errors['ProgramObjects'] = $model->getErrors();

                if ($save) {
                    $transaction->commit();
                    return Json::encode($model);
                } else {
                    $transaction->rollBack();
                    return Json::encode($errors);
                }
            }
            return Json::encode($post);
        }
        return $this->render('create',compact('model'));
    }

    /**
     * Updates an existing ProgramObjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $progObjectsEvents = ProgObjectsEvents::findAll(['id_object'=>$id]) ? : [new ProgObjectsEvents()];
        $proObjectsNecessary = ProObjectsNecessary::findAll(['id_object'=>$id]) ? : [new ProObjectsNecessary()];
        $progObjectsWaites = ProgObjectsWaites::findAll(['id_object'=>$id]) ? : [new ProgObjectsWaites()];
        $progObjectsRiscs = ProgObjectsRiscs::findAll(['id_object'=>$id]) ? : [new ProgObjectsRiscs()];
        $save = true;
        $arr=[null];
        echo '<pre>';
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                $transaction = Yii::$app->getDb()->beginTransaction();
                $save &= $model->save();
                $errors['ProgramObjects'] = $model->getErrors();
                if ($save and Model::loadMultiple($progObjectsEvents,Yii::$app->request->post())) {
                    var_dump($progObjectsEvents);
                    foreach ($progObjectsEvents as $index=>$item){
                        $item->id_object = $model->id;
                        $item->step = $index;
                    }
                }
               // var_dump($arr);
                exit();

                if ($save) {
                    $transaction->commit();
                    return Json::encode($model);
                } else {
                    $transaction->rollBack();
                    return Json::encode($errors);
                }
            }
            return Json::encode($post);
        }

        return $this->render('update',compact('model'));
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
        $model = $this->findModel($id);
        $model->system_status = 0;
        $model->save(false);

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
