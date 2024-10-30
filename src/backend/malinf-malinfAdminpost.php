<?php

namespace MALINF\backend;

use MALINF\response;
use MALINF\prices\malinfHookprice;

class malinfAdminpost{
/**
 * handle form inputs both "save" and "save&change" 
 */
    public function postform( ){
         
        if(isset($_POST['save-malinf'])||isset($_POST['malinf-convert']) ){             
            $modo = sanitize_key($_POST['api-mode']);
            $actu = intval($_POST['act-step']);
            $tipo = sanitize_key($_POST['tipodec']);
            $manu = intval($_POST['manual-api']);
            $redo = sanitize_key($_POST['redon']);
            $alca = intval($_POST['sel-step']);
            $ar = ['modo'=>$modo,
                    'actual'=>$actu,
                    'tipodc'=>$tipo,
                    'manual'=>$manu,
                    'redond'=>$redo,
                    'alcanc'=>$alca];            
            if(update_option('malinf_bkops',json_encode($ar)));
            if(isset($_POST['malinf-convert'])&&$modo!=='disabled'){                
                $hp = new malinfHookprice(json_encode($ar));
                $hp->start();
            }  
        }        
    }
}
