<?php
namespace MALINF;

/** 
* @package MALINF
* @param $class_name: class names   
* @author Sebastopolys
* @abstract Enable autoloading of plugin classes in namespace 
**/

 class malinfAutoloader{
    
    public static function start(){
        spl_autoload_register([__CLASS__,'autoload']);
    }

    private static function autoload( $class_name ){
            /* Only autoload classes from this namespace */
            if (false === strpos($class_name,__NAMESPACE__)){
                return;
            }
            /* Remove namespace from class name */
            $class_file = str_replace( __NAMESPACE__ . '\\', '', $class_name );
            /* Convert class name format to file name format */
            //$class_file = strtolower( $class_file );
            $class_file = str_replace( '_', '-', $class_file );
            /* Convert sub-namespaces into directories */
            $class_path = explode( '\\', $class_file );
            $class_file = array_pop( $class_path );
            $class_path = implode( '/', $class_path );
            /* Load the class */
            require __DIR__ . '/src/' . $class_path .'/malinf-' . $class_file . '.php';
        }
    
    private function __destruct(){
        spl_autoload_unregister([__CLASS__, 'autoload']);
    }
}