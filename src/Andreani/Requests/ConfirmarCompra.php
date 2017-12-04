<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class ConfirmarCompra implements WebserviceRequest{
    
    // Sobre el destino
    protected $provincia;
    protected $localidad;
    protected $codigoPostal;
    protected $calle;
    protected $numero;
    protected $piso;
    protected $departamento;
    protected $codigoDeSucursal;
    protected $sucursalCliente;
    
    // Sobre el destinatario
    protected $nombreYApellido;
    protected $nombreYApellidoAlternativo;
    protected $tipoDeDocumento;
    protected $numeroDeDocumento;
    protected $email;
    protected $numeroDeCelular;
    protected $numeroDeTelefono;
   
    // Sobre la transaccion
    protected $numeroDeContrato;
    protected $numeroDeTransaccion;
    protected $tarifa;
    protected $valorACobrar;
    
    // Sobre el envio
    protected $categoriaDistancia;
    protected $categoriaFacturacion;
    protected $categoriaPeso;
    protected $peso;
    protected $detalleProductosEntrega;
    protected $detalleProductosRetiro;
    protected $volumen;
    protected $valorDeclarado;
    
    public function setDatosDestino($provincia = null,$localidad = null,$codigoPostal = null,$calle = null,$numero = null,$piso = null,$departamento = null,$codigoDeSucursal = null,$sucursalCliente = null){
        $this ->setProvincia($provincia)
                ->setLocalidad($localidad)
                ->setCodigoPostal($codigoPostal)
                ->setCalle($calle)
                ->setNumero($numero)
                ->setPiso($piso)
                ->setDepartamento($departamento)
                ->setCodigoDeSucursal($codigoDeSucursal)
                ->setSucursalCliente($sucursalCliente);
    }
    
    public function setDatosDestinatario($nombreYApellido = null,$nombreYApellidoAlternativo = null,$tipoDeDocumento = null,$numeroDeDocumento = null,$email = null,$numeroDeCelular = null,$numeroDeTelefono = null){
        $this ->setNombreYApellido($nombreYApellido)
                ->setNombreYApellidoAlternativo($nombreYApellidoAlternativo)
                ->setTipoDeDocumento($tipoDeDocumento)
                ->setNumeroDeDocumento($numeroDeDocumento)
                ->setEmail($email)
                ->setNumeroDeCelular($numeroDeCelular)
                ->setNumeroDeTelefono($numeroDeTelefono);
    }
    
    public function setDatosTransaccion($numeroDeContrato = null,$numeroDeTransaccion = null,$tarifa = null,$valorACobrar = null){
        $this ->setNumeroDeContrato($numeroDeContrato)
                ->setNumeroDeTransaccion($numeroDeTransaccion)
                ->setTarifa($tarifa)
                ->setValorACobrar($valorACobrar);
    }
    
    public function setDatosEnvio($peso = null, $volumen = null,$valorDeclarado = null, $categoriaDistancia = null,$categoriaFacturacion = null, $categoriaPeso = null, $detalleProductosEntrega = null,$detalleProductosRetiro = null){
        $this ->setCategoriaDistancia($categoriaDistancia)
                ->setCategoriaFacturacion($categoriaFacturacion)
                ->setCategoriaPeso($categoriaPeso)
                ->setPeso($peso)
                ->setDetalleProductosEntrega($detalleProductosEntrega)
                ->setDetalleProductosRetiro($detalleProductosRetiro)
                ->setVolumen($volumen)
                ->setValorDeclarado($valorDeclarado);
    }
 
    public function getProvincia() {
        return $this->provincia;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
        return $this;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
        return $this;
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
        return $this;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function setCalle($calle) {
        $this->calle = $calle;
        return $this;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
        return $this;
    }

    public function getPiso() {
        return $this->piso;
    }

    public function setPiso($piso) {
        $this->piso = $piso;
        return $this;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
        return $this;
    }

    public function getCodigoDeSucursal() {
        return (string) $this->codigoDeSucursal;
    }

    public function setCodigoDeSucursal($codigoDeSucursal) {
        $this->codigoDeSucursal = $codigoDeSucursal;
        return $this;
    }

    public function getSucursalCliente() {
        return $this->sucursalCliente;
    }

    public function setSucursalCliente($sucursalCliente) {
        $this->sucursalCliente = $sucursalCliente;
        return $this;
    }

    public function getNombreYApellido() {
        return (string) $this->nombreYApellido;
    }

    public function setNombreYApellido($nombreYApellido) {
        $this->nombreYApellido = $nombreYApellido;
        return $this;
    }

    public function getNombreYApellidoAlternativo() {
        return (string) $this->nombreYApellidoAlternativo;
    }

    public function setNombreYApellidoAlternativo($nombreYApellidoAlternativo) {
        $this->nombreYApellidoAlternativo = $nombreYApellidoAlternativo;
        return $this;
    }

    public function getTipoDeDocumento() {
        return $this->tipoDeDocumento;
    }

    public function setTipoDeDocumento($tipoDeDocumento) {
        $this->tipoDeDocumento = $tipoDeDocumento;
        return $this;
    }

    public function getNumeroDeDocumento() {
        return (string) $this->numeroDeDocumento;
    }

    public function setNumeroDeDocumento($numeroDeDocumento) {
        $this->numeroDeDocumento = $numeroDeDocumento;
        return $this;
    }

    public function getEmail() {
        return (string) $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getNumeroDeCelular() {
        return (string) $this->numeroDeCelular;
    }

    public function setNumeroDeCelular($numeroDeCelular) {
        $this->numeroDeCelular = $numeroDeCelular;
        return $this;
    }

    public function getNumeroDeTelefono() {
        return (string) $this->numeroDeTelefono;
    }

    public function setNumeroDeTelefono($numeroDeTelefono) {
        $this->numeroDeTelefono = $numeroDeTelefono;
        return $this;
    }

    public function getNumeroDeContrato() {
        return $this->numeroDeContrato;
    }

    public function setNumeroDeContrato($numeroDeContrato) {
        $this->numeroDeContrato = $numeroDeContrato;
        return $this;
    }

    public function getNumeroDeTransaccion() {
        return $this->numeroDeTransaccion;
    }

    public function setNumeroDeTransaccion($numeroDeTransaccion) {
        $this->numeroDeTransaccion = $numeroDeTransaccion;
        return $this;
    }

    public function getTarifa() {
        return $this->tarifa;
    }

    public function setTarifa($tarifa) {
        $this->tarifa = $tarifa;
        return $this;
    }

    public function getValorACobrar() {
        return $this->valorACobrar;
    }

    public function setValorACobrar($valorACobrar) {
        $this->valorACobrar = $valorACobrar;
        return $this;
    }

    public function getCategoriaDistancia() {
        return $this->categoriaDistancia;
    }

    public function setCategoriaDistancia($categoriaDistancia) {
        $this->categoriaDistancia = $categoriaDistancia;
        return $this;
    }

    public function getCategoriaFacturacion() {
        return $this->categoriaFacturacion;
    }

    public function setCategoriaFacturacion($categoriaFacturacion) {
        $this->categoriaFacturacion = $categoriaFacturacion;
        return $this;
    }

    public function getCategoriaPeso() {
        return $this->categoriaPeso;
    }

    public function setCategoriaPeso($categoriaPeso) {
        $this->categoriaPeso = $categoriaPeso;
        return $this;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = (int) $peso;
        return $this;
    }

    public function getDetalleProductosEntrega() {
        return (string) $this->detalleProductosEntrega;
    }

    public function setDetalleProductosEntrega($detalleProductosEntrega) {
        $this->detalleProductosEntrega = $detalleProductosEntrega;
        return $this;
    }

    public function getDetalleProductosRetiro() {
        return (string) $this->detalleProductosRetiro;
    }

    public function setDetalleProductosRetiro($detalleProductosRetiro) {
        $this->detalleProductosRetiro = $detalleProductosRetiro;
        return $this;
    }

    public function getVolumen() {
        return (int) $this->volumen;
    }

    public function setVolumen($volumen) {
        $this->volumen = $volumen;
        return $this;
    }

    public function getValorDeclarado() {
        return (int) $this->valorDeclarado;
    }

    public function setValorDeclarado($valorDeclarado) {
        $this->valorDeclarado = $valorDeclarado;
        return $this;
    }

    public function getWebserviceIndex() {
        return 'confirmacion_compra';
    }
    
}
