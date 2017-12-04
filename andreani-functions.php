<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \Andreani\Andreani;
use \Andreani\Requests\ObtenerEstadoDistribucionCodificado;

//Agrega envios Andreani como metodo de envio internamente
function wc_andreani_agregar_envio_andreani( $methods ) {
	$methods['andreani'] = 'WC_Andreani';
	return $methods;
}
add_filter( 'woocommerce_shipping_methods', 'wc_andreani_agregar_envio_andreani' );

// =========================================================================
/**
 * Add DNI field
 *
 */
add_action( 'woocommerce_after_checkout_billing_form', 'wc_andreani_checkout_field_andreani' );
function wc_andreani_checkout_field_andreani( $checkout ) {
		woocommerce_form_field( 'dni_andreani', array(
			'type'          => 'text',
			'class'         => array('form-row-first'),
			'label'         => __('DNI'),
			'required'      => true,			
			), $checkout->get_value( 'dni_andreani' ));
}

add_action('woocommerce_checkout_process', 'wc_andreani_checkout_field_process_andreani');
function wc_andreani_checkout_field_process_andreani() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['dni_andreani'] )
        wc_add_notice( __( 'El campo <strong>DNI</strong> es obligatorio' ), 'error' );
}

add_action( 'woocommerce_checkout_update_order_meta', 'wc_andreani_checkout_field_update_order_meta_andreani' );
function wc_andreani_checkout_field_update_order_meta_andreani( $order_id ) {
    if ( ! empty( $_POST['dni_andreani'] ) ) {
        update_post_meta( $order_id, 'dni_andreani', sanitize_text_field( $_POST['dni_andreani'] ) );
    }
}

add_action( 'woocommerce_review_order_before_submit', 'wc_andreani_check_if_andreani' );
function wc_andreani_check_if_andreani( $chosen_method ) {
	$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
	$chosen_shipping = $chosen_methods[0]; 
	if (strpos($chosen_shipping, 'andreani') === false) {
		echo "<script>";
		echo 'jQuery("#dni_andreani").val("123");';
		echo 'jQuery("#dni_andreani_field").hide();';
		echo "</script>";
	}else{
		echo "<script>";
		echo 'jQuery("#dni_andreani_field").show();';
		echo 'jQuery("#dni_andreani").val("");';
		echo "</script>";
	}		
}



// =========================================================================
/**
 * Function wc_andreani_andreani_leer_sucursales
 *
 */
add_action( 'wp_ajax_andreani_leer_sucursales', 'wc_andreani_andreani_leer_sucursales' );
add_action( 'wp_ajax_nopriv_andreani_leer_sucursales', 'wc_andreani_andreani_leer_sucursales' );
function wc_andreani_andreani_leer_sucursales(){
	
	$session = WC()->session;
	if ( ! isset( $session ) ) {
		wp_die();
	}
	$log = new WC_Logger();
	$log->add('andreani','Data recibida y a colocar en la sesion: '.$_REQUEST['data']);
	$session->set('cp_sucursal_andreani', $_REQUEST['data']);
}


// =========================================================================
/**
 * Function enqueue_andreani_scripts
 *
 */
add_action( 'wp_enqueue_scripts', 'wc_andreani_enqueue_andreani_scripts' );
function wc_andreani_enqueue_andreani_scripts() {
if ( function_exists( 'is_woocommerce' ) ) {
	if ( ! is_checkout() ) {
		wp_dequeue_script( 'andreani-script' );
	} else {
		wp_enqueue_script( 'andreani-script', plugin_dir_url( __FILE__ ) . '/js/andreani.js', array('jquery') );
		wp_localize_script( 'andreani-script', 'objeto_url_ajax_lf',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
}
}


// =========================================================================
/**
 * Function check_if_andreani_selected
 *
 */
add_action( 'woocommerce_review_order_before_submit', 'wc_andreani_check_if_andreani_selected' );
function wc_andreani_check_if_andreani_selected( $chosen_method ) {
	$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
	$chosen_shipping = $chosen_methods[0]; 
	$chosen_shipping = explode(" ",$chosen_shipping);
	$session = WC()->session;
	?><script>
		jQuery("#cp_andreani_destino_field").hide();
		function buscar_cp_andreani(evt){
			evt.preventDefault();
			val = jQuery("#cp_sucursal").val();
			jQuery("#cp_andreani_destino").val(val);			
			if(val !== '0'){
					jQuery.post(

					objeto_url_ajax_lf.ajax_url, 
					{
						'action': 'andreani_leer_sucursales',
						'data': val
					}, 
					function(response){
						console.log(response);
					}
					).done(function(responseString) {
						var response = JSON.parse(responseString);
						if(response.error){
							console.log(response.msg);
						}else{
							console.log(response.error);
							jQuery(document.body).trigger("update_checkout");
					}
				});
			}
		}

		function llenar_campo(val){
			jQuery("#cp_andreani_destino_field").val(val)
		}
	</script>
<?php
	if ($chosen_shipping[0] === 'andreani' && ($chosen_shipping[1] === 'sucursal' || $chosen_shipping[1] === 'sucursal_stg')) {
		echo "<h5>Ingresa el código postal de la sucursal andreani donde quieres recibir tu compra</h5>";
		echo '<input style="margin-bottom:15px" type="text" id="cp_sucursal"/>';
		echo '<a href class="button" style="width: unset; font-size: 18px; margin-bottom: 15px;" id="buscar_cp" onclick="buscar_cp_andreani(event)">Buscar</a>';
		echo "<div id='andreani-agencia-info'></div>";
		if(WC()->session->get('cp_sucursal_andreani') !== ''){
			echo "<script>jQuery('#cp_sucursal').val(\"".WC()->session->get('cp_sucursal_andreani')."\")</script>";
		}
	}else{
		echo "<script>llenar_campo('1')</script>";
	}
}


// =========================================================================
/**
 * Function andreani_filter_checkout_fields
 *
 */
add_filter( 'woocommerce_checkout_fields', 'wc_andreani_filter_checkout_fields' );
function wc_andreani_filter_checkout_fields($fields){
    $fields['andreani'] = array(
            'cp_andreani_destino' => array(
                'type' => 'text',
                'required'      => true,
				'label' => __( 'Sucursal andreani' ),
				'class'      => array('form-row-wide'),
				'default' => ''	
			),
			);
	
	$cp = WC()->session->get('cp_sucursal_andreani');
	if($cp !== ''){
		$fields['andreani']['cp_andreani_destino']['default'] = $cp;
	}

    return $fields;
}


// =========================================================================
/**
 * Function andreani_extra_checkout_fields
 *
 */
add_action( 'woocommerce_checkout_after_customer_details' ,'wc_andreani_extra_checkout_fields' );
function wc_andreani_extra_checkout_fields(){ 
		$checkout = WC()->checkout(); 
		// because of this foreach, everything added to the array in the previous function will display automagically
		foreach ( $checkout->checkout_fields['andreani'] as $key => $field ) : ?>
	
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
	
			<?php endforeach; ?>
	
<?php }



// =========================================================================
/**
 * Function wc_andreani_save_extra_checkout_fields
 *
 */
// save the extra field when checkout is processed
add_action( 'woocommerce_checkout_create_order', 'wc_andreani_save_extra_checkout_fields', 10, 2 );
function wc_andreani_save_extra_checkout_fields( $order, $data ){
 
    // don't forget appropriate sanitization if you are using a different field type
    if( isset( $data['cp_andreani_destino'] ) ) {
		$order->update_meta_data( 'cp_andreani_destino', $data['cp_andreani_destino'] );
		$order->update_meta_data( 'sucursal_andreani', WC()->session->get('sucursal_andreani')->Sucursal );
		$order->save();		
    }
}


// =========================================================================
/**
 * Function wc_andreani_cargar_sucursal_info_andreani
 *
 */
add_action( 'woocommerce_review_order_before_submit', 'wc_andreani_cargar_sucursal_info_andreani', 12 );
function wc_andreani_cargar_sucursal_info_andreani() {
	global $wp_session;
	$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
	$chosen_shipping = $chosen_methods[0]; 
	$envio = explode(" ",$chosen_shipping);
	if ($envio[0] === 'andreani' && ($envio[1] === 'sucursal' || $envio[1] === 'sucursal_stg') && WC()->session->get('sucursal_andreani') !== '') {
		$agencia = WC()->session->get('sucursal_andreani');
		if($agencia === NULL || $agencia === ''){
			echo "<h4>Introduce un código postal válido</h4>";
		}else{
			echo "<div style='margin-bottom:2em;'>";
			echo "<h3>Agencia seleccionada</h3>";
			echo "<strong>Dirección: </strong>".$agencia->Direccion."</br>";
			echo "<strong>Horario: </strong>".$agencia->HoradeTrabajo."</br>";
			echo "<strong>Teléfono: </strong>".$agencia->Telefono1;
			echo "</div>";
		}
	}
}




// =========================================================================
/**
 * Function wc_andreani_agregar_columna_andreani
 *
 */
// Agregar columna de numeros de tracking, en el panel de ordenes
add_filter( 'manage_edit-shop_order_columns', 'wc_andreani_agregar_columna_andreani');
function wc_andreani_agregar_columna_andreani( $columns ) {
	$new_columns = array();
	foreach ( $columns as $column_name => $column_info ) {
		$new_columns[ $column_name ] = $column_info;
		if ( 'order_total' === $column_name ) {
			$new_columns['rastreo_andreani'] = __( 'NroEnvio Andreani', 'my-textdomain' );
		}
	}
	return $new_columns;
}


// =========================================================================
/**
 * Function wc_andreani_agregar_contenido_columna_andreani
 *
 */
add_action( 'manage_shop_order_posts_custom_column', 'wc_andreani_agregar_contenido_columna_andreani' );
function wc_andreani_agregar_contenido_columna_andreani( $column ) {
    global $post;
    if ( 'rastreo_andreani' === $column ) {
		$order = wc_get_order( $post->ID );
		echo $order->get_meta('tracking_andreani');
    }
}


// =========================================================================
/**
 * Function wc_andreani_agregar_estilo_columna_andreani
 *
 */
add_action( 'admin_print_styles', 'wc_andreani_agregar_estilo_columna_andreani' );
function wc_andreani_agregar_estilo_columna_andreani() {
		$css = '.column-rastreo_andreani { width: 9%; }';
		wp_add_inline_style( 'woocommerce_admin_styles', $css );
}



// =========================================================================
/**
 * Shortcode [tracking_andreani]
 *
 */
add_shortcode ( 'tracking_andreani' , 'wc_andreani_tracking_andreani_func' );
function wc_andreani_tracking_andreani_func( $atts, $content= NULL) {
	if($_POST['id']){
		require_once trailingslashit( ABSPATH ) . 'wp-content/plugins/woocommerce-andreani/vendor/autoload.php';		
		$andreani = new Andreani('STAGING_WS','andreani','test');	
		$request = new ObtenerEstadoDistribucionCodificado();
		$request->setCodigoDeCliente('CL0003750');			
		$request->setNumeroDeEnvio($_POST['id']);			
		$response = $andreani->call($request);
		ob_start();		
		if($response->isValid() && $response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->Estado !== ''){
			echo "<h2>Envío Nro. ".$response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->NumeroAndreani."</h2>";
			echo "<table>";
			echo "<tr>";
				echo "<td>Estado</td>";
				echo "<td>".$response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->Estado."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>Fecha</td>";
				echo "<td>".$response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->Fecha."</td>";
			echo "</tr>";
			if($response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->IdMotivo !== -1){
				echo "<tr>";
					echo "<td>Motivo</td>";
					echo "<td>".$response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->Motivo."</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else if($response->isValid() && $response->getMessage()->Respuestas->EnviosExitosos->EnvioExitoso->Estado === ''){
			echo "<h2>No se encontró el número de envío</h2>";
		}else{
			echo "<h2>Error interno</h2>";
		}
		return ob_get_clean();		
	}
}