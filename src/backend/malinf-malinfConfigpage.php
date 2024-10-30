<?php

namespace MALINF\backend; 

class malinfConfigpage{
    /** 
     * Admin settings page 
     */
    private $output = null;    
    
   // private $getpar = null;

    public function __construct(){
        $this->cpost = new malinfConfigpost();
        $this->getpar = new malinfGetplpage();
    }

    public function printC(){ 
        $this->cpost->configpost();
       // $ops = json_decode($ops);
       // $api = json_decode($api);     
        $this->output = $this->header();
        $this->output .= $this->config_form();     
        $this->output .= $this->footer();        
       return $this->output;      
    }

    private function header(){
        $hd = '<div id="malinf-bk" class="wrap">
        <h1>Maldita inflacion</h1>
        <h2>Configuracion del plugin</h2>';
        return  $hd;
    }

    private function config_form(){
        $cf = ' <div id="conf_cont">
                    <div id="warning-box">
                        <h2>ATENCION ! Estas funciones no pueden ser revertidas</h2>
                        <p>Se modificaran registros en la base de datos de forma permanente</p>
                    </div>
                    <form method="POST" name="curr_switch">
                        <div id="curr-cont" class="malinf-item">
                            <div id="curr-info">
                                <h3>Convertir precios a valor de TDC</h3>                                
                                <p>Si todos los precios estan expresados en dolares, esta accion permite convertir la moneda a pesos al actualizar</p>
                                <p>Al ejecutar esta funcion, el precio actual de los productos sera tomado como valor de TDC en la proxima acualizacion de precios</p>
                                <p>Se toman los precios regulares y se guardan en la base de datos como valor de TDC</p>
                            </div>
                            <div>' . $this->currencybutton()
                            . '</div>
                        </div>
                        <div id="cldb-cont" class="malinf-item">
                            <div id="cldb_info">
                                <h3>Base de datos</h3>
                                <p>Eliminar todos los registros del plugin en la base de datos al desintalar el plugin</p>
                                <p>Los precios no cambiaran al desinstalar o eliminar el plugin</p>
                            </div>
                            <div>
                                <input type="checkbox" name="clean_db" id="clean_db" class="checkbox"/>
                                <label id="cl_db_lab" for="clean_db">Limpiar base de datos</label>
                            </div>
                        </div>
                    </form>
                </div>';
        return $cf;
    }


    private function currencybutton(){
        if($this->getpar->getUrlPage('but')=='submit_div'){
            $tb = '<pre>Los valores TDC han sido editados para todos los productos</pre><pre>Ejecuta una actualizacion automatica o manual para editar los precios</pre>';
        } else {
            $tb = '<input type="submit" name="currency_switch" id="currency_switch" class="button button-primary" value="Ejecutar"/>
            ';
        }
        return $tb;
    }

    private function footer(){
        $ft = '</div>';
        return $ft;
    }
}