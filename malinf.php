<?php
declare(strict_types=1);
namespace MALINF;
/**
 * @link              https://digitalek.com/
 * @since             1.0.0
 * @package           MALINF
 * Plugin Name:       Maldita Inflacion
 * Plugin URI:        https://digitalek.com/
 * Description:       Cambia automaticamente los precios de tu tienda en base al cambio oficial / blue del dolar
 * Name: 			  Sarmiento
 * Version:           1.0.4
 * Author:            Sebastopolys
 * Author URI:        https://digitalek.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       malinf
 */
if(file_exists(__FILE__)&&__FILE__){
    require plugin_dir_path(__FILE__).'malinfAutoloader.php';
    require plugin_dir_path(__FILE__).'malinfConfig.php';
}
malinfAutoloader::start();
$out = new malinfInit();
    if(is_admin()){      
        $out->start();          
    }
