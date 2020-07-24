<?php

namespace app\controllers\app;

use app\models\Atz;
use app\models\Organizations;
use app\models\ProgObjectsEvents;
use app\models\Program;
use app\models\User;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class AtzController extends Controller
{
    public function actionIndex()
    {
        $program = \Yii::$app->getSession()->get('program');
        if (!$program)
            $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
        //$atz = Atz::findAll(['id_program'=>$program->id]) ? : [new Atz()];
        $save = true;
        if (Yii::$app->request->post()) {
            $json = Yii::$app->request->post();
            foreach ($json['Atz'] as $index => $item) {
                $a = Atz::findOne(['id_program' => $program->id, 'elem' => $index]);
                if (!$a) {
                    $a = new Atz();
                    $a->id_program = $program->id;
                    $a->elem = $index;
                }
                $a->cost_b = $item['cost_b'];
                $a->cost_v = $item['cost_v'];
                $save &= $a->save();
            }
            if ($save) return 1;
            else return 0;
        }
        return $this->render('index');
    }

    public function actionMainAtz($id_org)
    {
        if(!Yii::$app->user->can('dku')) 
            $id_org = $this->getCurrentOrgId();

        if (!empty($id_org)) {
            $organization = Organizations::find()->where(['id' => $id_org])->asArray()->one();
            $region = Organizations::find()->where(['id' => $id_org])->one()->region->region;
        }

        return $this->render('mainAtz', ['organization' => $organization ?? null, 'region' => $region]);
    }

    public function getCurrentOrgId()
    {
        if (!empty($id_user = Yii::$app->user->id ?? null)) {
            if (!empty($id_org = User::findOne($id_user)->id_org ?? null)) {
                return $id_org;
            }
        }

        return false;
    }
}
