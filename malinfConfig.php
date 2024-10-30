<?php

namespace MALINF;

class malinfConfig{

    public static $plname = null;
    public static $plprfx = null;
    public static $plvers = null;
    public static $dbvers = null;
    public static $plpath = null;
    public static $pluurl = null;
    public static $instop = null;
    public static $backop = null;
    public static $khtmls = null;

    function __construct(){  
        $methods = get_class_methods(__CLASS__); 
        foreach ($methods as $value) {
            if($value!=='__construct'){              
                return $this->$value();
            }          
        }
    }


    
    public static function plname(){
        self::$plname = 'Maldita Inflacion';        
    }
    private static function plprfx(){
        self::$plprfx = 'malinf';        
    }
    private static function plvers(){
        self::$plvers = '1.0.5';        
    }
    private static function dbvers(){
        self::$dbvers = '0.0.1';        
    }
    private static function plpath(){
        self::$plpath = dirname(__FILE__);
    }
    private static function pluurl(){
        self::$pluurl = plugin_dir_url(__FILE__);
    }
    private static function instop(){
        self::$instop = get_option(self::$plprfx.'-cambio');
    }
    private static function backop(){
          self::$backop = get_option(self::$plprfx.'_bkops');
    }    

    public static function khtmls(){
        self::$khtmls = ['div'=>[],
        'p'=>['b'=>[]],
        'h1'=>[],
        'h2'=>[],
        'h3'=>[],
        'h4'=>[],
        'b'=>[],
        'q'=>[],
        'em'=>[],    
        'hr'=>[],
        'a' => ['href' => [],'target'=>[]],        
        'ul'=>['li'=>[]],
        'ol'=>['li'=>[]]
        ];    
        return self::$khtmls;    
    }
}

new malinfConfig();
