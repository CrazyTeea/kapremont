<?php


namespace app\controllers\app;


use app\facades\ProgramStatus;
use app\models\EventsFiles;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\ProgramObjectsEvents2;
use app\models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class ProgramController extends AppController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (Yii::$app->user->can('root') or
            Yii::$app->user->can('mgsu') or
            Yii::$app->user->can('orglist_view') or
            Yii::$app->user->can('faiv_admin') or
            Yii::$app->user->can('dep') or
            Yii::$app->user->can('dku')) {
            return $this->redirect(['/organization/list']);
        }
        return $this->render('index');
    }

    private function addRow(Table $table, $val)
    {
        $table->addRow(25);
        $table->addCell(25)->addText($val->step + 1);
        $table->addCell(25)->addText(htmlspecialchars($val->step_name ?? ''));
        $table->addCell(25)->addText(htmlspecialchars($val->date_event_end ? Yii::$app->formatter->asDate($val->date_event_start, 'php: d F Y') : null));
        $table->addCell(25)->addText(htmlspecialchars($val->date_event_end ? Yii::$app->formatter->asDate($val->date_event_end, 'php: d F Y') : null));
        $table->addCell(25)->addText(htmlspecialchars($val->cost_real));
        $table->addCell(25)->addText(htmlspecialchars($val->sum_bud_fin));
        $table->addCell(25)->addText(htmlspecialchars($val->fin_vnebud_ist));
        $table->addCell(25)->addText($val->done ? '+' : '-');
        $table->addCell(25)->addText(htmlspecialchars($val->access_document) . ' ' . htmlspecialchars($S = $val->file ? $val->file->file_name : null));
        $table->addCell(25)->addText(htmlspecialchars($val->comment));
        $table->addCell(25)->addText($val->doneExpert ? '+' : '-');
        $table->addCell(25)->addText(htmlspecialchars($val->commentExpert));
    }


    public function actionExportPlan()
    {
        $get = array_filter(Yii::$app->request->get(), function ($val) {
            if ($val !== 'null' or !$val)
                return $val;
        });
        $query = ProgramObjects::find()->joinWith(['region', 'org'])->where(['program_objects.system_status' => 1]);
        if (ArrayHelper::keyExists('id', $get)) {
            $query->andWhere(['id' => $get['id']]);
        }
        if (ArrayHelper::keyExists('region', $get)) {
            $query->andWhere(['like', 'regions.region', $get['region']]);
        }
        if (ArrayHelper::keyExists('name', $get)) {
            $query->andWhere(['like', 'organizations.name', $get['name']]);
        }

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
        $section = $phpWord->addSection(['orientation' => 'landscape']);


        foreach ($query->all() as $object) {
            $section->addText($object->name);
            if ($object->svedenia) {
                $kek = $section->addTable([
                    'borderSize' => 1,
                    'borderColor' => '999999',
                    'cellMargin' => 50
                ]);
                $kek->addRow(25);
                $kek->addCell(25)->addText('#');
                $kek->addCell(25)->addText('Этап');
                $kek->addCell(25)->addText('Дата начала');
                $kek->addCell(25)->addText('Дата окончания');
                $kek->addCell(25)->addText('Общая Фактическая Стоимость реализации (тыс.руб.)');
                $kek->addCell(25)->addText('Фактическая Сумма бюджетного финансирования (тыс. руб.)');
                $kek->addCell(25)->addText('Софинанси-рование (тыс. руб.)');
                $kek->addCell(25)->addText('Отметка о завершении этапа');
                $kek->addCell(25)->addText('Подтверждающие документы');
                $kek->addCell(25)->addText('Комментарий (текстовое поле Заполняет ВУЗ)');
                $kek->addCell(25)->addText('Эксперт МОН +/-');
                $kek->addCell(25)->addText('Комментарий эксперта МОН )');
                foreach ($object->svedenia as $sv) {
                    $this->addRow($kek, $sv);
                    foreach (ProgramObjectsEvents2::find()
                                 ->where(['id_object' => $object->id])
                                 ->andWhere(['>', 'step', $sv->step])
                                 ->andWhere(['<', 'step', $sv->step + 1])
                                 ->orderBy('step ASC')
                                 ->all() as $sv2) {
                        $this->addRow($kek, $sv2);
                    }

                }
            }

        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $path = Yii::getAlias('@webroot') . '/uploads/helloWorld.docx';
        $objWriter->save($path);
        Yii::$app->response->sendFile($path)->send();
        unlink($path);

    }


    public function actionIsApprove($id_org = 0)
    {

        $id = $id_org ?: Yii::$app->session->get('user')->id_org;


        $gg = Program::find()->where(['id_org' => $id])->one();

        // $gg = ArrayHelper::merge($gg,['organization'=>$gg->org->name]);


        return Json::encode($gg);
    }

    public function actionExport($type)
    {
        $objs = Program::findAll(['system_status' => 1]);
        $param = 'export';
        if ($type == 2)
            $param = 'export2';

        $html = $this->renderPartial("_$param", compact('objs'));
        $reader = new HTML();
        $spreadsheet = $reader->loadFromString($html);
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');

        $path = Yii::getAlias('@webroot') . "/uploads/$param";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $writer->save("$path/$param.xls");
        Yii::$app->response->sendFile("$path/$param.xls")->send();
        if (file_exists("$path/$param.xls"))
            unlink("$path/$param.xls");
    }

    public function actionDkuExport()
    {
        $objects = ProgramObjects::find()->where(['system_status' => 1])->groupBy(['id_org'])->all();
        $sum = 0;
        $export = [];


        $dku_status = [
            'not' => 'В обработке',
            'approved' => 'Рассмотрено ДКУ',
            'rejected' => 'Резерв'
        ];

        $dep_status = [
            'not' => 'В обработке',
            'approved' => 'Согласовано ДЭП',
            'rejected' => 'Резерв'
        ];


        foreach ($objects as $object) {
            $export[] = [
                'id_org' => $object->id_org,
                'region' => $object->region->region,
                'org' => $object->org->name,
                'sum' => $object->program->finance_volume * 1000,
                'dep_status' => $dep_status[$object->org->dep_status],
                'atz_nb' => $object->program->finance_events * 1000,
                'atz' => 0,
                'atz_bud_fin' => $object->program->dku_atz,
                'dku_status' => $dku_status[$object->org->dku_status]
            ];
        }

        $html = $this->renderPartial('_dkuExport', ['export' => $export]);
        $reader = new HTML();
        $spreadsheet = $reader->loadFromString($html);
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');

        $path = Yii::getAlias('@webroot') . "/uploads/dkuExport";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $writer->save("$path/dkuExport.xls");
        Yii::$app->response->sendFile("$path/dkuExport.xls")->send();
        if (file_exists("$path/dkuExport.xls"))
            unlink("$path/dkuExport.xls");
    }

    public function actionDownloadEvent($id_event)
    {
        return EventsFiles::download($id_event);
    }

    public function actionSetValue($id_org)
    {
        $model = Program::findOne(['id_org' => $id_org]);
        if (!$model)
            $model = new Program();
        if ($model) {
            $model[Yii::$app->request->post('value')] = Yii::$app->request->post(Yii::$app->request->post('value'));
            return Json::encode([
                'success' => $model->save(),
                'errors' => $model->getErrors()
            ]);
        }
    }

    public function actionApprove()
    {
        if (Yii::$app->request->isPost) {
            $program = Yii::$app->session->get('program');
            $errrMsg = 'Что то пошло не так, звоните фиксикам';
            $status = false;
            $id_org = Yii::$app->session->get('user')->id_org;
            if (!$program)
                $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
            if ($program->file_exist) {
                Yii::$app->db->createCommand("UPDATE program set p_status = 1 where id_org = {$id_org} ")->execute();
                $status = new ProgramStatus($program->id_org);
                $objs = ProgramObjects::findAll(['id_org' => $id_org]);
                foreach ($objs as $item) {
                    $item->status = 1;
                    $item->save(false);
                }

                $status = true;
            } else  $errrMsg = 'Файл должен быть загружен';
            $program = Program::findOne(['id_org' => Yii::$app->session->get('user')->id_org]);
            return Json::encode(['programStatus' => $program->p_status, 'status' => $status, 'msg' => $errrMsg]);
        }

        /*$objects = ProgramObjects::findAll(['system_status'=>1,'id_org'=>$program->id_org]);
        if ($objects) {
            foreach ($objects as $object){
                $object->status = 0;
                $object->save(false);
            }
        }*/
    }
}