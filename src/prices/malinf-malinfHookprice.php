<?php

namespace MALINF\prices;

use MALINF\apilog\malinfResponse;

class malinfHookprice{
/**
 * Hooks to WC price, change price depending on plugin settings
 */
    private $mpr = null;
    private $cpr = null;
    private $metop = [];
    private $bkop = [];
    private $apirp = null;

    public function __construct($bkop){        
        $this->apir = new malinfResponse();  
        $this->bkop = $bkop; 
        $this->apirp =  $this->tipodec();
    }

    public function start(){        
        add_action('init',[$this,'get_meta_product']);      
    }   

    public function get_meta_product(){
        // get all products with meta field not empty        
        $all_ids = get_posts( array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
        ));
        $bok = json_decode($this->bkop);
         
        $mod = $bok->modo;
        
        if($mod =='disabled'||null==$bok||null==$mod) return;   
 
        foreach ( $all_ids as $id ) {
            if(get_post_meta( $id, 'malinf_meta', true )){                 
                if($this->priceloop(get_post_meta( $id, 'malinf_meta', true ),$id,$bok)); 
            }
            else{
                if(get_post_meta($id,'_regular_price')){
                    $rpr = get_post_meta($id,'_regular_price');
                    update_post_meta($id,'_price',$rpr[0]);
                }
            }                  
        }          
    }   

    public function priceloop($meta,$id,$bak){
        // change price on database       
        
   
        $val = intval($this->apirp);
         
            // mode            
            if($bak->modo =='api'){
                $dummy = $meta*$val;
            }
            if($bak->modo =='manual'){
                $dummy = $meta*$bak->manual;
            }
      
            // round
            $pri = $dummy/$bak->alcanc;
                if($bak->redond=='down'){$pric = floor($pri);}
                if($bak->redond=='up'){$pric = ceil($pri);}          
                if($bak->redond=='no'){$pric = $pri;}
            // convert   
            $price = $pric*$bak->alcanc;
            // save
            if(get_post_meta(intval($id), '_sale_price')){
                $sprice = get_post_meta(intval($id), '_sale_price');                
                update_post_meta( intval($id), '_price', intval($sprice[0]));
                update_post_meta( intval($id), '_regular_price', intval($price));
            }  
            else{
                update_post_meta( intval($id), '_regular_price', intval($price));
                update_post_meta( intval($id), '_price', intval($price));    
            }          
                    
    }
  
    private function tipodec(){
        if(!null == $this->apir->call($this->bkop)){
            return $this->apir->call($this->bkop);
        }
        return;
            
    }

}
