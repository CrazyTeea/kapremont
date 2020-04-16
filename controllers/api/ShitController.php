<?php


namespace app\controllers\api;


use app\facades\ProgramStatus;
use app\models\Program;
use yii\rest\Controller;

class ShitController extends Controller
{
    /**
     * @return array
     */
    public function actionData(){

        $programs = Program::find()->where(['system_status'=>1])->orderBy('id_org')->all();

        $ret = [];
        foreach ($programs as $program){
            $ob_fin_vol = [0,0,0,0,0];
            $obj_cost = ['pr'=>0,'res'=>0,'depRes'=>0,'depPr'=>0];
            $obj_count = [0,0,0,0,0,'dep'=>0];
            foreach ($program->objects as $object){
                $obj_count[$object->status]++;
                if ($object->dep_status=='approved')
                    $obj_count['dep']++;
                foreach ($object->svedenia as $item){

                    if ($object->dep_status=='approved' and !$object->type)
                        $obj_cost['depRes']+=($item->cost_real*1);
                    if ($object->dep_status=='approved' and $object->type)
                        $obj_cost['depPr']+=($item->cost_real*1);
                    if ($object->status == 2) {
                        if ($object->type)
                            $obj_cost['res'] += ($item->cost_real * 1);
                        else
                            $obj_cost['pr'] += ($item->cost_real * 1);
                    }

                    $ob_fin_vol[$object->status]+=($item->cost_real*1);
                }
            }

            $status = new ProgramStatus($program->id_org);

            $dku_status = [
                'not' => 'В обработке',
                'approved' => 'Согласовано ДКУ',
                'rejected' => 'Резерв'
            ];

            $dep_status = [
                'not' => 'В обработке',
                'approved' => 'Согласовано ДЕП',
                'rejected' => 'Резерв'
            ];

            $ret['program'][] = [
                'id_org'=>$program->id_org,
                'region'=>$program->org->region->region,
                'org_name'=>$program->org->name,
                'pdf_export'=>$program->file_exist,
                'program_status'=>$status->isNotApproved() ? 'Не согласовано' : 'согласовано',
                'obs_limits'=>round($program->finance_volume,2),
                'obs_reserv'=>'-',
                'pred_zakl'=>round($program->finance_volume,2) -
                    round($program->cost,2) + round($program->finance_events,2)
                , //$program->finance_volume - $ob_fin_vol
                'kap_rem'=>round($program->cost,2),
                'obj_all'=>count($program->objects),
                'abj_obr'=>$obj_count[1],
                'abj_appr'=>$obj_count[2],
                'abj_nappr'=>$obj_count[3],
                'abj_prog'=>$obj_count[4],
                'abj_dep'=>$obj_count['dep'],
                'cost_pr'=>round($obj_cost['pr'],2),
                'cost_res'=>round($obj_cost['res'],2),
                'cost_depPr'=>round($obj_cost['depPr'],2),
                'cost_depRes'=>round($obj_cost['depRes'],2),
                'dep_status' => $dep_status[$program->org->dep_status],
                'atz_nb'=>0,
                'atz'=>$program->finance_events,
                'atz_bud_fin'=>0,
                'dku_status'=> $dku_status[$program->org->dku_status]
            ];
        }

        return $ret;
    }
}