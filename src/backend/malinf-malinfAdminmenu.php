<?php

namespace MALINF\backend;

use MALINF\malinfConfig; 

class malinfAdminmenu {
/**
 * Hooks to WP menu dashboard
 * Pronts both welcome and admin settings page
 * @uses: malinfAdminpost() - malinfAdminpage() - malinfWelcome() - malinfConfig();
 */
    private $wPage = null;
    private $aPage = null;
    private $cPage = null;
    private $pos = null;

    public function __construct(){  
        $this->wPage = new malinfWelcomepage();
        $this->aPage = new malinfAdminpage();
        $this->cPage = new malinfConfigpage();
        $this->pos = new malinfAdminpost();
    }

    public function menuPages(){
        add_menu_page(
            __( malinfConfig::$plname, malinfConfig::$plprfx),
            __( malinfConfig::$plname,malinfConfig::$plprfx),
            'manage_options','malinf_welcome',
            array($this,'malinfWelcome'),
            'dashicons-calculator'
            );       
		add_submenu_page( 'malinf_welcome', malinfConfig::$plname, 'Ajustes', 'manage_options',
					'malinf_admin', [$this,'malinfAdmin']);
        add_submenu_page( 'malinf_welcome', malinfConfig::$plname, 'Configuracion', 'manage_options',
					'malinf_config', [$this,'malinfConfig']);	    
    }

    public function malinfAdmin(){  
        $ops = sanitize_option('malinf_bkops',get_option('malinf_bkops'));
        $api = sanitize_option('malinf_apival',get_option('malinf_apival'));   
        echo $this->aPage->printA($ops,$api);
    }

    public function malinfConfig(){
        echo $this->cPage->printC();
    }

    public function malinfWelcome(){      
       echo wp_kses_post($this->wPage->printW(),malinfConfig::khtmls());
    }
}
