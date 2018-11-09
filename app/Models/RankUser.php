<?php

namespace App\Models;

class RankUser
{
    var $uid;
    var $username;
    var $solPro;
    var $allPro;
    var $submitNum;
    var $acSubmitNum;
    var $rank;
    var $grade;

    function __construct($id, $name)
    {
        $this->uid = $id;
        $this->username = $name;
        $this->solPro = array();
        $this->allPro = array();
        $this->submitNum = $this->acSubmitNum = $this->grade = 0;
        $this->rank = 10000000;
    }

    function addStatus($status, $startTime)
    {
        if (in_array($status->pid, $this->solPro)) {
            if ($status->result == 1) {
                $this->acSubmitNum++;
            }

            $this->submitNum++;
            return;
        }

        // 1表示AC  9表示CE
        if ($status->result == 1) {

            $duration = strtotime($status->submit_time) - strtotime($startTime);
            if ($duration < 0) {
                $duration *= -1;
            }

            $minutes = intval(($duration % 3600) / 60);
            $this->grade += $minutes;

            if (array_key_exists($status->pid, $this->allPro)) {
                $this->grade += 20 * $this->allPro[$status->pid];
            } else {
                $this->allPro[$status->pid] = 0;
            }

            array_push($this->solPro, $status->pid);
            $this->acSubmitNum++;
        } else if ($status->result != 9) {
            if (!array_key_exists($status->pid, $this->allPro)) {
                $this->allPro[$status->pid] = 1;
            } else {
                $this->allPro[$status->pid]++;
            }
        }

        $this->submitNum++;
    }
}