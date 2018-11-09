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
    var $penalty;

    function __construct($id, $name)
    {
        $this->uid = $id;
        $this->username = $name;
        $this->solPro = array();
        $this->allPro = array();
        $this->submitNum = $this->acSubmitNum = $this->penalty = 0;
        $this->rank = 10000000;
    }

    function addStatus($status, $startTime)
    {
        if (array_key_exists($status->pid, $this->solPro)) {
            // if ($status->result == 1) {
            //     $this->acSubmitNum++;
            // }

            // $this->submitNum++;
            return;
        }

        // 1表示AC  9表示CE
        if ($status->result == 1) {

            $duration = strtotime($status->submit_time) - strtotime($startTime);
            if ($duration < 0) {
                $duration *= -1;
            }

            $minutes = intval($duration / 60);
            $this->penalty += $minutes;

            if (array_key_exists($status->pid, $this->allPro)) {
                $this->penalty += 20 * $this->allPro[$status->pid];
            } else {
                $this->allPro[$status->pid] = 0;
            }
            $this->solPro[$status->pid]=$duration;
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