<?php

/*
Plugin Name: Woocommerce Andreani
Plugin URI: http://ecomerciar.com/woocommerce-andreani
Description: Integración de andreani para realizar envíos a través de la plataforma WooCommerce.
Version: 1.0
Author: Ecomerciar
Author URI: http://ecomerciar.com
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once 'andreani-class.php';
require_once 'andreani-shipping.php';
require_once 'andreani-functions.php';

// Creamos paginas necesarias al instalar el plugin				
function andreani_install(){
	$contenido = '<h2>Número de envío</h2>
	<form method="post">
	<input type="text" name="id"style="width:40%"><br>
	<br />
	<input name="submit_button" type="submit"  value="Consultar"  id="update_button"  class="update_button"/>
	</form>
	[tracking_andreani]';
	if(! post_exists('Rastreo', $contenido)){
		wp_insert_post( array(
			'post_title'     => 'Rastreo',
			'post_name'      => 'rastreo-andreani',
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_content'   => $contenido,
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		) );
	}
}
register_activation_hook(__FILE__,'andreani_install');