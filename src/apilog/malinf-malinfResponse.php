<?php

namespace MALINF\apilog;

class malinfResponse{
/**
 * MAke API CALL, save api option in _options table if success  
 */
    private $apiurl = 'https://api.bluelytics.com.ar/v2/latest' ;
    
    public function call($bkop){ 
        $res = wp_remote_get($this->apiurl ); 
		if(is_wp_error($res)){
			echo "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ". $res->get_error_message();
			return null;
		} 
        $resp = json_decode($res['body']);        
        if(null!==json_decode($bkop)->tipodc&&$res['response']['code']==200){
            $bktp =   json_decode($bkop)->tipodc;
            if($bktp=='oficial'){
                $respo = $resp->oficial->value_avg;
            }
            if($bktp=='blue'){
                $respo = $resp->blue->value_avg;
            }
            if(null==$bktp){
                $respo = $resp->blue->value_avg;
            }
            update_option('malinf_apival',json_encode([$respo,time()]),true);  
        }
        else{           
            delete_option('malinf_apival');
            $respo = null;
        }                    
    return $respo;
    }
}
