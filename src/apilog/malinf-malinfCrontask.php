<?php

namespace MALINF\apilog;

use MALINF\prices\malinfHookprice;

class malinfCrontask{
/**
 *  cron manage - not WO cron, but timestamp saved in _options table
 */
    private $apiop = null;
    private $bkop = null;
    private $hprice = null;

    public function __construct($bkop){ 
        $this->apiop = get_option('malinf_apival');
        $this->hprice = new malinfHookprice($bkop);
    }

    public function startcron($bkop){
        $bk = json_decode($bkop);
        $bkm = $bk->modo;
        if($bkm !=='disabled'){
            $timestamp = intval(json_decode($this->apiop)[1]);
            $fval = intval($bk->actual)*86400;
            $future = intval($timestamp)+$fval;
            $lap = $future-time();
            if(time()>=$future){
                $this->hprice->start();                 
            }
            else{
                return;            
            }
        }
        else{
            return;        
        }
    return;        
    }
}
