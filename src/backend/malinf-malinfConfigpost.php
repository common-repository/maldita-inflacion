<?php
namespace MALINF\backend;

use MALINF\prices\malinfHookprice;

class malinfConfigpost{

    public function configpost(){

        if(isset($_POST['currency_switch'])){           

            $pr_ids = get_posts( array(
                'post_type' => 'product',
                'numberposts' => -1,
                'post_status' => 'publish',
                'fields' => 'ids',
            ));

            foreach ( $pr_ids as $id ) {

                $pprice = '';                                              
                $pprice = get_post_meta( $id, '_regular_price' );    
                update_post_meta( $id, 'malinf_meta', $pprice[0] );
                

                        
            }
            
            header('location:'.$this->geturlpath().'&but=submit_div' );

        }

        if( isset( $_POST['malinf-curr-convert'] ) ){   
            $ops = '';
            if( get_option( 'malinf_bkops' ) ){
                $ops = get_option('malinf_bkops'); 
            }            
            $hp = new malinfHookprice( $ops );
            $hp->start( );
 
            header('location:'.$this->geturlpath().'&but=completed' );
        } 

    }
    
    public function geturlpath(){
     
            $protocol = is_ssl() ? 'https://' : 'http://';
            return ($protocol) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
     
    }

}
