<?php

namespace MALINF\prices;

class malinfMetaprice{
/**
 * Adds custom field on product editor metabox
 */

    public function methook(){
        add_action('woocommerce_product_options_pricing',[$this,'metapricehoook']);
        add_action('woocommerce_process_product_meta', [$this,'savemeta'], 10, 2 );
    }

    public function metapricehoook(){
        $ot = '<div class="options_group">'; 
        woocommerce_wp_text_input( array(
            'id'                => 'malinf_meta',
            'value'             => get_post_meta( get_the_ID(), 'malinf_meta', true ),
            'label'             => 'Valor TDC',
            'type'              => 'number',
            'desc_tip'          => 'true',
            'description'       => 'Precio expresado en unidades del tipo de cambio',
            'custom_attributes' => array(
				'step' 	=> 'any',
				'min'	=> '0'
			) 
        ) ); 
	$ot.= '</div>';
    return $ot; 
    }

    public function savemeta( $id, $post ){ 
       if( !empty( sanitize_key($_POST['malinf_meta']) ) ) {
            if ( is_string( $_POST['malinf_meta'] ) )
				//$_POST=str_replace(',','.',$_POST);
                $valTDC = floatval($_POST['malinf_meta']);
				update_post_meta( $id, 'malinf_meta', $valTDC );
		} 
		else {
			delete_post_meta( $id, 'malinf_meta' );
		}	
    }
}
