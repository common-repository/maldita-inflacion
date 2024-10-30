<?php

namespace MALINF;

use MALINF\backend\malinfAdminmenu;
use MALINF\prices\malinfHookprice;
use MALINF\prices\malinfMetaprice;

use MALINF\apilog\malinfCrontask;
use MALINF\backend\malinfAdminpost;

use MALINF\backend\malinfGetplpage;

class malinfInit{
/**
 * Main Class
 */
    private $mpags = null;
    private $bkop = null;
   // private $apir = null;
    private $hopr = null;
    private $adp = null;
    private $cron = null;
    private $pag = null;

    public function __construct(){
        $this->mpags = new malinfAdminmenu();         
        $this->bkop = get_option('malinf_bkops');
        if(!null==$this->bkop){
            $this->hopr = new malinfHookprice($this->bkop);
            $this->cron = new malinfCrontask($this->bkop);
        }
        else{            
            $def_ops = [
                "modo"=>"disabled",
                "actual"=>1,
                "tipodc"=>"blue",
                "manual"=>1,
                "redond"=>"up",
                "alcanc"=>10
                ];
                $json = json_encode($def_ops);
                add_option('malinf_bkops',$json);            
        }
        
      //  $this->apir = get_option('malinf_apival');
         
        $this->adp = new malinfAdminpost();
        
        $this->pag = new malinfGetplpage();
    }

    public function start(){    
        add_action('admin_init',[$this,'backstyle']);
        add_action('admin_menu', [$this,'menuPages']);
        add_action('admin_init',[$this,'editmetapr']);
        //
        if(!null==$this->bkop){
            $this->cron->startcron($this->bkop);            
        }
        $this->adp->postform();        
    }

    public function backstyle(){ 
       if(esc_html($this->pag->getUrlPage('page'))=='malinf_admin'
       ||esc_html($this->pag->getUrlPage('page'))=='malinf_welcome'
       ||esc_html($this->pag->getUrlPage('page'))=='malinf_config'){
            add_action('admin_enqueue_scripts',[$this, 'bastyle']);
        }
    }

    public function menuPages(){
        $this->mpags->menuPages();    
    }

    public function editmetapr(){
        $metapr = new malinfMetaprice();
        $metapr->methook();        
    }    

    public function bastyle(){
		wp_register_style( 'malinfbackcss', plugin_dir_url(__DIR__).'scripts/css/malinf-back.css' );
		wp_enqueue_style(  'malinfbackcss' );

        wp_register_script( 'malinfscript',plugin_dir_url(__DIR__).'scripts/js/malinf-back.js', ['jquery'], '1', true);
        wp_enqueue_script( 'malinfscript' );
	}
}
