<?php
 
namespace MALINF\backend;

class malinfGetplpage{
/**
 * Get & returns url par of current page
 */
    public function getUrlPage( $tab ){ 
	     
		if(isset($_GET[$tab])){
            $active_tab=sanitize_key($_GET[$tab]);
			return $active_tab;
        }
		return null;
	}
}