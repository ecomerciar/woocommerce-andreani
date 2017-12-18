<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Andreani\Andreani;
use Andreani\Requests\ConsultarSucursales;
use Andreani\Requests\CotizarEnvio;

//Creamos nuestra clase WC_Andreani
function envios_andreani_init() {
	if ( ! class_exists( 'WC_Andreani' ) ) {
		class WC_Andreani extends WC_Shipping_Method {
			/**
			 * Constructor de la clase
			 *
			 * @access public
			 * @return void
			 */
			public function __construct($instance_id=0) {
				$this->id                 = 'andreani'; // Id for your shipping method. Should be unique.
				$this->method_title       = 'Andreani';  // Title shown in admin
				$this->method_description = __('Envios con Andreani','woocommerce'); // Description shown in admin
				$this->title = __('Envío con Andreani', 'andreani');
				$this->instance_id = absint( $instance_id );
				$this->supports             = array(
					'shipping-zones',
					'instance-settings',
					'instance-settings-modal'
				);
				// Definimos la configuración
				$this->init();

				add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );				
			}			 

			/**
			 * Inicialización de las opciones
			 *
			 * @access public
			 * @return void
			 */
			function init() {
				$this->form_fields     = array(); // No hay config global, solo de instancia
				$this->instance_form_fields =  array(
                    'username' => array(
                            'title' => __( 'Nombre de Usuario', 'woocommerce' ),
                            'type' => 'text'
                    ),
                    'password' => array(
                            'title' => __( 'Password', 'woocommerce' ),
                            'type' => 'password'
						),
					'ambiente' => array(
						'title'       => 'Ambiente',
						'type'        => 'select',
						'default'     => '',
						'desc_tip'    => true,
						'options'     => array(
							'prod' => 'Producción',
							'test' => 'Prueba'
						)
					),
					'codigocliente' => array(
						'title'       => 'Codigo del Cliente',
						'type'        => 'text',
						'default'     => '',
						'desc_tip'    => true,
					),
					'codigocliente_stg' => array(
						'title'       => 'Codigo del Cliente - Prueba',
						'type'        => 'text',
						'default'     => '',
						'desc_tip'    => true,
					),
					'clase' => array(
						'title'       => 'Si existe la clase',
						'type'        => 'select',
						'default'     => '',
						'desc_tip'    => true,
						'options'     => array(
							'nada' => 'Seleccionar'
						)
					),
					'accion' => array(
						'title'       => 'Entonces',
						'type'        => 'select',
						'default'     => '',
						'desc_tip'    => true,
						'options'     => array(
							'nada' => 'No hacer nada',
							'desactivar_metodo' => 'Desactivar método de envio',
							'activar_metodo' => 'Activar método de envio',
							'envio_gratis' => 'Envio gratis'
						)
					),
					'debug' => array(
                            'title' => __( 'Debug log?', 'woocommerce' ),
                            'type' => 'checkbox'
					),
					'titulo_contrato1' => array(
						'title' => __( 'Contrato Entrega', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato1' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Envío a domicilio',
						'desc_tip'    => true,
					),
					'contrato1' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
					'titulo_contrato2' => array(
						'title' => __( 'Contrato Urgente', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato2' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Envío a domicilio express',
						'desc_tip'    => true,
					),
					'contrato2' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
					'titulo_contrato3' => array(
						'title' => __( 'Contrato Sucursal', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato3' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Envío a sucursal',
						'desc_tip'    => true,
					),
					'contrato3' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
					'titulo_contrato1_stg' => array(
						'title' => __( 'Contrato Entrega - Prueba', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato1_stg' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Contrato Entrega - Prueba',
						'desc_tip'    => true,
					),
					'contrato1_stg' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
					'titulo_contrato2_stg' => array(
						'title' => __( 'Contrato Urgente - Prueba', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato2_stg' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Envío a domicilio express - Prueba',
						'desc_tip'    => true,
					),
					'contrato2_stg' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
					'titulo_contrato3_stg' => array(
						'title' => __( 'Contrato Sucursal - Prueba', 'textdomain' ), 
						'type' => 'title'
					),
					'nombre_contrato3_stg' => array(
						'title'       => 'Nombre envío',
						'type'        => 'text',
						'description'        => 'Nombre visible para el comprador',
						'default'     => 'Envío a sucursal - Prueba',
						'desc_tip'    => true,
					),
					'contrato3_stg' => array(
						'title'       => 'Número Contrato',
						'type'        => 'text',
						'description'        => 'Dejar vacío si no se quiere usar',
						'default'     => '',
						'desc_tip'    => true,
					),
				);
				// Cargamos todas las clases disponibles de WC y las insertamos en la config de andreani
				$clases = WC()->shipping->get_shipping_classes();				
				foreach ($clases as $clase) {
					$this->instance_form_fields['clase']['options'][$clase->name] = $clase->name;
				}
			}

			// =========================================================================
			/**
			 * function calculate_shipping.
			 *
			 * @access public
			 * @param mixed $package
			 * @return void
			 */
			public function calculate_shipping( $package = array() ) {

				$productos = array();
				$accion = $this->verificar_clases($productos);
				if($this->get_instance_option('debug') === 'yes'){
					$log = new WC_Logger();
					$log->add('andreani','Accion: '.$accion);
				}
				
				add_action( 'woocommerce_after_checkout_billing_form', 'wc_andreani_checkout_field_andreani' );	
				add_action('woocommerce_checkout_process', 'wc_andreani_checkout_field_process_andreani');
				add_action( 'woocommerce_checkout_update_order_meta', 'wc_andreani_checkout_field_update_order_meta_andreani' );			

				if($accion === 'envio_gratis' || $envio_gratis === 'yes'){
					
					$this->addRate('gratis');
					return;

				}else if($accion === 'activar_metodo' || $accion === 'nada'){
					$this->cargar_dependencias();
					$contratos = $this->cargar_contratos($this->get_instance_option('ambiente'));					
					foreach($contratos as $nombrecontrato => $nrocontrato){
						$nombre = explode(" ", $nombrecontrato);
						$tipocontrato = array_shift($nombre);
						$nombre_contrato = array_shift($nombre);
						$nombre = implode(" ", $nombre);
						if($this->get_instance_option('debug') === 'yes'){
							$log = new WC_Logger();
							$log->add('andreani','tipo contrato: '.$nombre_contrato);				
						}
						if($nombre_contrato === 'sucursal' || $nombre_contrato === 'sucursal_stg'){
							if($this->get_instance_option('debug') === 'yes'){
								$log = new WC_Logger();
								$log->add('andreani','Data en la sesion ya existente: '.WC()->session->get('cp_sucursal_andreani'));
							}
							if(WC()->session->get('cp_sucursal_andreani') !== '' && WC()->session->get('cp_sucursal_andreani') !== NULL){
								$andreani = new Andreani($this->get_instance_option('username'),$this->get_instance_option('password'),$this->get_instance_option('ambiente'));					
								$request = new ConsultarSucursales();
								$request->setCodigoPostal(WC()->session->get('cp_sucursal_andreani'));
								$response = $andreani->call($request);
								$agencia = $response->getMessage()->ConsultarSucursalesResult->ResultadoConsultarSucursales[0];
								WC()->session->set('sucursal_andreani', $agencia);
								$precio = $this->cotizar_envio($productos, WC()->session->get('cp_sucursal_andreani'), $nrocontrato, $agencia->Sucursal, $nombre_contrato);	
							}else{
								$precio = 0;
							}
						}else{
							$cp = intval(WC()->customer->get_shipping_postcode());		
							$precio = $this->cotizar_envio($productos, $cp, $nrocontrato, '', $nombre_contrato);
						}
						if($precio !== -1){
							$rate = array(
								'id' => 'andreani '.$nombre_contrato.' '.$nrocontrato.' '.$this->get_instance_option_key(),
								'label' =>  $nombre,
								'cost' => $precio,
								'calc_tax' => 'per_item'
							);
							$this->add_rate( $rate );
						}
					}
				}
			}

			
			
			// =========================================================================
			/**
			 * function cargar_operativas
			 *
			 * @access private
			 * @return array
			 */
			private function cargar_contratos($entorno){
				$res = array();
				if($entorno === 'prod'){
					$res['contrato1 entrega '.$this->get_instance_option('nombre_contrato1')] = $this->get_instance_option('contrato1');
					$res['contrato2 urgente '.$this->get_instance_option('nombre_contrato2')] = $this->get_instance_option('contrato2');
					$res['contrato3 sucursal '.$this->get_instance_option('nombre_contrato3')] = $this->get_instance_option('contrato3');
				}else{
					$res['contrato1 entrega_stg '.$this->get_instance_option('nombre_contrato1_stg')] = $this->get_instance_option('contrato1_stg');
					$res['contrato2 urgente_stg '.$this->get_instance_option('nombre_contrato2_stg')] = $this->get_instance_option('contrato2_stg');
					$res['contrato3 sucursal_stg '.$this->get_instance_option('nombre_contrato3_stg')] = $this->get_instance_option('contrato3_stg');
				}
				$res = array_filter($res);
				return $res;		
			}



			// =========================================================================
			/**
			 * function verificar_clases
			 *
			 * @access private
			 * @return boolean
			 */
			private function verificar_clases(&$productos){
				$accion = $this->get_instance_option('accion');
				$clase = $this->get_instance_option('clase');
				$items = WC()->cart->get_cart();
				
				if($accion !== 'nada' && $clase !== 'nada'){
					$condicion = false;
					$contador = 0;
					foreach($items as $item => $values) { 
				
						$product =  wc_get_product( $values['data']->get_id());
						if($clase === $product->get_shipping_class()){
							$condicion = true;
							$contador++;
						}
						$producto = array(
							"metroscubicos" => floatval(wc_get_dimension( $product->get_length(), 'm' )) * floatval(wc_get_dimension( $product->get_width(), 'm' )) * floatval(wc_get_dimension( $product->get_height(), 'm' )),							
							"peso" => floatval(wc_get_weight( $product->get_weight(), 'kg' )),
							"precio" => floatval($product->get_price())
						);
						for ($x = 0; $x < $values['quantity']; $x++) {
							array_push($productos,$producto);
						}
					}
					// Si hay envio gratis para X producto, y en el carrito hay otros items, entonces se desactiva el envio gratis
					if($accion === 'envio_gratis' && $contador !== count($items)){
						$condicion = false;
					}
				}else{
					foreach($items as $item => $values) { 
						$product =  wc_get_product( $values['data']->get_id());
						$producto = array(
							"metroscubicos" => floatval(wc_get_dimension( $product->get_length(), 'm' )) * floatval(wc_get_dimension( $product->get_width(), 'm' )) * floatval(wc_get_dimension( $product->get_height(), 'm' )),						
							"peso" => floatval(wc_get_weight( $product->get_weight(), 'kg' )),
							"precio" => floatval($product->get_price())
						);
						for ($x = 0; $x < $values['quantity']; $x++) {
							array_push($productos,$producto);
						}					
					}
					$condicion = false;
				}
				

				if($condicion){
					return $accion;
				}else if(!$condicion && $accion === 'activar_metodo'){
					return 'desactivar_metodo';
				}else{
					return 'nada';
				}
			}

			// =========================================================================
			/**
			 * function cargar_dependencias
			 *
			 * @access private
			 * @return void
			 */
			private function cargar_dependencias(){
				require_once 'vendor/autoload.php';				
			}

			// =========================================================================
			/**
			 * function cotizar_envio
			 *
			 * @access private
			 * @param int $cp 
			 * @return void
			 */
			private function cotizar_envio($productos, $cp, $nrocontrato, $cs, $nombre_contrato){
				$items = WC()->cart->get_cart();
				$peso_total = $precio_total = 0;
				$hay_producto_cero = false;
				foreach($productos as $producto){
					$peso_total += $producto['peso'];
					$precio_total += $producto['precio'];
					if($producto['peso'] == 0 || $producto['peso'] == '' ){
						$hay_producto_cero = true;
						$producto_cero = $producto;
						break;
					}
				}			
				if($hay_producto_cero || $peso_total === ''){
					if($this->get_instance_option('debug') === 'yes'){
						$log = new WC_Logger();
						if(isset($producto_cero)){
							$log->add('andreani','Detectado peso 0 en el producto: ');
							$log->add('andreani', print_r($producto_cero,true));
						}else{
							$log->add('andreani','Detectado peso 0');
						}
					}
					return -1;
				}
				$request = new CotizarEnvio();
				if( $this->get_instance_option('ambiente') === 'prod' ){
					$request->setCodigoDeCliente($this->get_instance_option('codigocliente'));
				}else{
					$request->setCodigoDeCliente($this->get_instance_option('codigocliente_stg'));
				}
				$request->setNumeroDeContrato($nrocontrato);
				$request->setCodigoPostal($cp);
				$request->setPeso($peso_total);
				$request->setValorDeclarado($precio_total);
				$request->setCodigoDeSucursal($cs);
				$andreani = new Andreani($this->get_instance_option('username'),$this->get_instance_option('password'),$this->get_instance_option('ambiente'));
				$response = $andreani->call($request);
				if($response->isValid()){
					$tarifa = $response->getMessage()->CotizarEnvioResult->Tarifa;
					return $tarifa;
				}else if($nombre_contrato === 'sucursal' || $nombre_contrato === 'sucursal_stg'){
					return 0;
				}else{
					return -1;
				}		
			}
		}
	}
}
add_action( 'woocommerce_shipping_init', 'envios_andreani_init' );