<?php
namespace App\Models;

class RankUser{
    var $userId;
    var $userName;
    var $solPro;       
    var $allPro;
    var $submitNum;
    var $acSubmitNum;
    var $rank;
    var $grade;
    function __construct( $id, $name ) {
        $this->userId = $id;
        $this->userName = $name;
        $this->solPro=array();        
        $this->allPro=array();
        $this->submitNum=$this->acSubmitNum=$this->grade=0;
        $this->rank=10000000;
    }

    function addStatus($status,$startTime){
        if(in_array($status->pid,$this->solPro)){
            if($status->result==1){
                $this->acSubmitNum++;
            }
            $this->submitNum++;
            return;
        }
        if($status->result==1){   // 1表示AC  9表示CE

            $t=strtotime($status->submit_time)-strtotime($startTime);
            if($t<0){
                $t*=-1;
            }
            $mins = intval(($t%3600)/60);
            $this->grade+=$mins;
            if(array_key_exists($status->pid,$this->allPro)){
                $this->grade+=20*$this->allPro[$status->pid]; 
            }else{
                $this->allPro[$status->pid]=0;
            }            

            array_push($this->solPro,$status->pid);
            $this->acSubmitNum++;
        }else if($status->result!=9)
        {
            if(!array_key_exists($status->pid,$this->allPro)){
                $this->allPro[$status->pid]=1;
            }else{
                $this->allPro[$status->pid]++;
            }
        }
        $this->submitNum++;
    }
}


?>