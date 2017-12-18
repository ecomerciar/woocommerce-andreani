<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \Andreani\Andreani;
use \Andreani\Requests\ConfirmarCompra;

// =========================================================================
/**
 * function wc_andreani_generar_envio_andreani.
 *
 */
function wc_andreani_generar_envio_andreani( $order_id ){
	$order = wc_get_order( $order_id );	
	$envio_seleccionado = reset( $order->get_items( 'shipping' ) )->get_method_id();
	$envio = explode(" ", $envio_seleccionado);
	if($envio[0] === 'andreani'){
		$datos = get_option($envio[3]);		
		require_once plugin_dir_path( __FILE__ ). 'vendor/autoload.php';
		$andreani = new Andreani($datos['username'],$datos['password'],$datos['ambiente']);		
		$request = wc_andreani_cargar_datos($order, $datos, $envio);
		$response = $andreani->call($request);		
		if($datos['debug'] === 'yes'){
			$log = new WC_Logger();		
			$log->add( 'andreani', "Datos enviados: ".print_r($request,true));						
			$log->add( 'andreani', "Respuesta del server: ".print_r($response,true));	
		}	
		if($response->isValid()){
			$tracking = $response->getMessage()->ConfirmarCompraResult->NumeroAndreani;
			$order->update_meta_data('tracking_andreani', $tracking );
			$order->save();
		}	
	}
}
add_action( 'woocommerce_order_status_completed', 'wc_andreani_generar_envio_andreani');


// =========================================================================
/**
 * function wc_andreani_cargar_datos
 *
 */
function wc_andreani_cargar_datos($order,$datos, $envio){
	$countries_obj = new WC_Countries();
	$country_states_array = $countries_obj->get_states();
	$request = new ConfirmarCompra();
	if($order->get_shipping_first_name()){
		$provincia = $country_states_array['AR'][$order->get_shipping_state()];
		$request->setDatosDestino($provincia, $order->get_shipping_city(), $order->get_shipping_postcode(),$order->get_shipping_address_1(),0,0,0,'','');
		$request->setDatosDestinatario($order->get_shipping_first_name()." ".$order->get_shipping_last_name(),'','DNI',$order->get_meta('dni_andreani'),$order->get_billing_email(),$order->get_billing_phone(),'');
	}else{
		$provincia = $country_states_array['AR'][$order->get_billing_state()];
		$request->setDatosDestino($provincia, $order->get_billing_city(), $order->get_billing_postcode(),$order->get_billing_address_1(),0,0,0,'','');
		$request->setDatosDestinatario($order->get_billing_first_name()." ".$order->get_billing_last_name(),'','DNI',$order->get_meta('dni_andreani'),$order->get_billing_email(),$order->get_billing_phone(),'');
	}

	if($envio[1] === 'sucursal' || $envio[1] === 'sucursal_stg'){
		$request->setCodigoPostal($order->get_meta('cp_andreani_destino'));
		$request->setCodigoDeSucursal($order->get_meta('sucursal_andreani'));
	}

	$request->setDatosTransaccion($envio[2],$order->get_order_number(),'','');

	$items = $order->get_items();
	$nombres = '';
	$peso_total = $volumen_total = 0;	
	foreach ( $items as $item ) {
		$nombres .= $item['name']." | ";
		$product_id = $item['product_id'];
		$product_variation_id = $item['variation_id'];
		$product =  wc_get_product( $product_id );
		$product_variado =  wc_get_product( $product_variation_id );		
		if($product->get_weight() !== ''){
			$peso_total += $product->get_weight();
			$volumen_total += floatval(wc_get_dimension( $product->get_length(), 'm' )) * floatval(wc_get_dimension( $product->get_width(), 'm' )) * floatval(wc_get_dimension( $product->get_height(), 'm' ));	
		}else{
			$peso_total += $product_variado->get_weight();	
			$volumen_total += floatval(wc_get_dimension( $product_variado->get_length(), 'm' )) * floatval(wc_get_dimension( $product_variado->get_width(), 'm' )) * floatval(wc_get_dimension( $product_variado->get_height(), 'm' ));				
		}
	}
	$volumen_total = number_format($volumen_total, 6);	
	$request->setDatosEnvio($peso_total, $volumen_total,'', '','', '', $nombres,'');
	return $request;
}

