<?php

namespace MALINF\backend; 

class malinfAdminpage{
    /** 
     * Admin settings page 
     */
    private $output = null;     

    public function printA($ops,$api){ 
    
        $ops = json_decode($ops);
        $api = json_decode($api);     
        $this->output = $this->header();
        $this->output .= $this->apiform($ops,$api);     
        $this->output .= $this->footer();        
       return $this->output;      
    }

    public function header(){
        $hd = '<div id="malinf-bk" class="wrap">
        <h1>Maldita inflacion</h1>
        <h2>Convierte los precios a valor dolar blue/oficial de forma automatica o manual</h2>';
        return  $hd;
    }

    public function apiform($ops,$api){    
        
        $st = '<form method="post">'
        . $this->modo($ops)
        . $this->apimsg($ops,$api)
         . $this->apistatus($ops )
                  
                . $this->manual($ops) 
                . $this->redondear($ops) 
                . $this->savebutt() .
        '</form>';            
        return $st;
    }

    private function modo($ops){
        $modman=$modapi=$moddis='';          
        if($ops->modo=='api'){$modapi = 'checked';}
        if($ops->modo=='manual'){$modman = 'checked';}
        if($ops->modo=='disabled'){$moddis = 'checked';}
        if($ops->modo == null){$moddis = 'checked';} 
        $md ='<div id="api-box" class=" ">
        <h3>Modo</h3>
        <span>
            <label for="apim1">API</label>
            <input id="apim1" type="radio" name="api-mode" '.esc_attr($modapi).' radioc="1" value="api"/>
        </span>
        <span>
            <label for="apim2">Manual</label>
            <input id="apim2" type="radio" name="api-mode" '.esc_attr($modman).' radioc="2" value="manual"/>
        </span>
        <span>
            <label for="apim3">Desactivado</label>
            <input id="apim3" type="radio" name="api-mode" '.esc_attr($moddis).' radioc="3" value="disabled"/>
        </span>
        </div>';
    return $md;
    }

    private function apistatus($ops){ 
        $tdco=$tdcb=$hid='';
        if($ops->actual==null){$act = 1;}else{$act = $ops->actual;}
        if($ops->tipodc == 'oficial'){$tdco = 'checked';}
        if($ops->tipodc == 'blue'){$tdcb = 'checked';}
        if($ops->tipodc == null){$tdcb = 'checked';}
        if($ops->modo!=='api'){$hid = 'hide';}
  
        $as = '<div id="apistatus" class="malinf-item '.$hid.'">
        <h3>Api</h3><span><label for="api-actual">Actualizacion</label><input type="number" min="1" max="90" name="act-step" id="api-actual" value="'.esc_attr($act).'"/> dias</span>
        </div>
        <div id="tipodc" class="malinf-item '.$hid.'"><span><label for="tipo-ofi">Oficial</label><input type="radio" '.esc_attr($tdco).' name="tipodec" id="tipo-ofi" value="oficial"/></span><span><label for="tipo-blur">Blue</label><input type="radio" '.esc_attr($tdcb).' name="tipodec" id="tipo-blue" value="blue"/></span></div>';
        return $as;
    }

    private function manual($ops){         
        if($ops->manual == 0){$val = '';$vpla='Ingrese un valor';}
        else{$vpla='';$val=$ops->manual;}
       
        if($ops->modo!=='manual'){$hid='hide';}else{$hid='';}
        $ma = '<div id="manual" class="malinf-item '.$hid.'">
        <h3>Manual</h3>
            <label for="api-manual">Valor del tipo de cambio</label><input type="number" min="1" max="1000000" id="api-manual" placeholder="'.esc_attr($vpla).'" name="manual-api" value="'.$val.'"/>
        </div>';
        return $ma;
    }

    private function redondear($ops){
        $red = $ops->redond; $alc =$ops->alcanc; $mdoo = $ops->modo;
        $redu=$redd=$redn=$redu=$alc1o=$alc1oo=$alc1o='';
        if($red == 'up'){$redu = 'checked';}
        if($red == 'down'){$redd = 'checked';}
        if($red == 'no'){$redn = 'checked';}
        if($red == null){$redu = 'checked';}        
        
        if($alc=='10'){$alc1o = 'selected="selected"';}
        if($alc=='100'){$alc1oo = 'selected="selected"';}
        if($alc==null){$alc1o = 'selected="selected"';}

        if($mdoo=='disabled'){$jaid='hide';}else{$jaid='';}
        $rd = '<div id="redond" class="malinf-item '.$jaid.'"><h3>Redondeo</h3>            
        <span><label for="redono">No redondear</label><input type="radio" id="redono" name="redon" '.esc_attr($redn).' value="no"/></span><span><label for="redond">Abajo</label><input type="radio" id="redond" name="redon" '.esc_attr($redd).' value="down"/></span><span><label for="redonu">Arriba</label><input type="radio" id="redonu" name="redon" '.esc_attr($redu).' value="up"/></span>
            </div>
            <div id="alcance" class="malinf-item '.$jaid.'"><span><label for="steprd">Alcance</label><select name="sel-step" id="steprf">               
                <option value="10" '.esc_attr($alc1o).'>10</option>                
                <option value="100" '.esc_attr($alc1oo).'>100</option>
            </select></span>
            </div>';
        return $rd;
    }

    private function convert(){
        $co = ' 
            <input id="convert" type="submit" name="malinf-convert" value="CAMBIAR AHORA" class="button button-primary" >
             ';
        return $co;
    }

    private function apimsg($mod,$api){
        $am = '<div id="malinf-msg" class="malinf-item">';
        $timestamp = $api[1];
        $future =  intval($timestamp)+intval($mod->actual)*86400; // <- 5 min (300 s)
        $lap = $future-time();
        if(null==$api){
            $am .="API no esta conectada";
        }
        else{
            if($mod->modo!=='disabled'){
                $am .= "<p>Modo: ".esc_attr($mod->modo)."</p>
                <p>Ultima actualizacion: ".esc_attr(date('F j, Y H:i', $api[1]))."</p>";
            }
            else{
                $am .='<p>El plugin esta desactivado</p>';
            }
        }
        return $am.'</div>';
    }

    private function savebutt(){
        $sb = '<div id="malinf-submit" class="malinf-item">
        <input id="malinf-submit" type="submit" name="save-malinf" value="GUARDAR" class="button button-primary"/>
        '.$this->convert().'</div>';
        return $sb;
    }

    private function footer(){
        $ft = '</div>';
        return $ft;
    }
}
