<?php

namespace app\facades;

use app\models\ApproveStatus;
use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;

class ProgramStatus
{
    private $id_org;

    public function __construct($id_org)
    {
        $this->id_org = $id_org;

        $this->calculateStatus();
    }

    public function calculateStatus() // вычисляет нужный статус
    {

        if($this->isDraft()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_DRAFT);
        } else if($this->isNotApproved()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_REJECTED);
        } else if($this->isDep()) {
            if($this->isDku()) {
                $this->setStatus(Organizations::PROGRAM_STATUS_DKU_REVIEWED);
            } else {
                $this->setStatus(Organizations::PROGRAM_STATUS_DEP_REVIEWED);
            }
        }
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void //выставляет нужный статус
    {
        $query = Organizations::find()->where(['id' => $this->id_org])->one();
        $query->programm_status = $status;
        $query->save(false);
    }

    public function isToWork(): bool //возвращено на доработку
    {
        $v_obr = true;
        $na_dorabotku = false;

        $objs = ProgramObjects::find()->where(['id_org' => $this->id_org])->all();
        foreach($objs as $obj) {
            if($obj->astatus->id == ApproveStatus::STATUS_NOT_SEND) {
                $v_obr = false;
            }
            if($obj->astatus->id == ApproveStatus::STATUS_TO_WORK) {
                $na_dorabotku = true;
            }
        }

        if($v_obr == true && $na_dorabotku == true) {
            return true;
        }

        return false;
    }

    public function isDep(): bool //согласовано дЭп (опирается на организации)
    {
        $org = Organizations::find()->where(['id' => $this->id_org])->one();
        if($org->dep_status === 'approved') {
            return true;
        }

        return false;
    }

    public function isDku(): bool //согласовано дку(опирается на организации)
    {
        $org = Organizations::find()->where(['id' => $this->id_org])->one();
        if($org->dku_status === 'approved') {
            return true;
        }

        return false;
    }

    public function isDepDku()
    {
        if($this->isDep() && $this->isDku()) {
            return true;
        } else {
            return false;
        }
    }

    public function isNotApproved(): bool //не согласовано
    {
        $isNotApproved = false;
        $objs = ProgramObjects::find()->where(['id_org' => $this->id_org])->all();

        foreach($objs as $obj) {
            if(isset($obj->astatus) and $obj->astatus->id == ApproveStatus::STATUS_NOT_RECOMEND || $obj->dep_status == 'rejected') { // conditions to review
                $isNotApproved = true;
                break;
            }
        }

        return $isNotApproved;
    }

    public function isDraft() //черновик
    {
        $query = Program::find()->where(['id_org' => $this->id_org, 'system_status' => 1])->one();

        if($query->p_status == 0) {
            $isDraft = true;
        }

        return $isDraft ?? false;
    }

    public function getProgramStatus(): ?string
    {
        $org = Organizations::find()->where(['id' => $this->id_org])->one();

        return $org->programm_status ?? null;
    }
}