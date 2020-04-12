<?php

namespace app\facades;

use app\models\Organizations;
use app\models\ProgramObjects;

class ProgramStatus
{
    private $id_org;

    public function __construct($id_org)
    {
        $this->id_org = $id_org;

        // $this->calculateStatus();


    }

    public function calculateStatus()
    {
        if($this->isDraft()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_DRAFT);
        } else if($this->isNotApproved()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_REJECTED);
        } else if($this->isDep()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_DEP_REVIEWED);
        } else if($this->isDku()) {
            $this->setStatus(Organizations::PROGRAM_STATUS_DKU_REVIEWED);
        }
    }

    public function setStatus(string $status): void
    {
        $query = Organizations::find()->where(['id_org' => $this->id_org])->one();
        $query->programm_status = $status;
        $query->save(false);
    }

    public function isToWork()
    {
        $v_obr = true;
        $na_dorabotku = false;
    
        $objs = ProgramObjects::find()->where(['id' => $this->id_org])->all();
        foreach($objs as $obj) {
            if($obj->astatus->id == 1) {
                $v_obr = false;
            }
            if($obj->astatus->id == 4) {
                $na_dorabotku = true;
            }
        }
        
        if($v_obr == true && $na_dorabotku == true) {
            return true;
        }

        return false;
    }

    public function isDep() //согласовано деп
    {
        $dep = true;
        $objs = ProgramObjects::find()->where(['id' => $this->id_org, 'system_status' => 1])->all();
        foreach($objs as $obj) {
            if($obj->dep_status != 'approved') {
                $dep = false;
            }
        }

        return $dep;
    }

    public function isDku(): bool //согласовано дку
    {
        $dku = true;
        $objs = ProgramObjects::find()->where(['id' => $this->id_org])->all();
        foreach($objs as $obj) {
            if($obj->dku_status !== 'approved') {
                $dku = false;
                break;
            }
        }

        return $dku;
    }

    public function isNotApproved(): bool //не согласовано
    {
        $isNotApproved = false;
        $objs = ProgramObjects::find()->where(['id' => $this->id_org])->all();

        foreach($objs as $obj) {
            if($obj->astatus == 'rejected' || $obj->dep_status == 'rejected') { // conditions to review
                $isNotApproved = true;
                break;
            }
        }

        return $isNotApproved;
    }

    public function isDraft(): bool //черновик
    {
        return true;
    }

    public function getProgramStatus(): string
    {
        $org = Organizations::find()->where(['id' => $this->id_org])->one();

        return $org->programm_status ?? null;
    }
}