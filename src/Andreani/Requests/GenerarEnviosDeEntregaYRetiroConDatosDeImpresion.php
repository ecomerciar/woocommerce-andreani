<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class GenerarEnviosDeEntregaYRetiroConDatosDeImpresion implements WebserviceRequest{
    
    // Sobre el destino
    protected $provincia;
    protected $localidad;
    protected $codigoPostal;
    protected $calle;
    protected $numero;
    protected $piso;
    protected $departamento;
    protected $idCliente;
    protected $sucursalDeRetiro;
    protected $sucursalDelCliente;
    
    // Sobre el destinatario
    protected $nombre;
    protected $apellido;
    protected $nombreAlternativo;
    protected $apellidoAlternativo;
    protected $tipoDeDocumento;
    protected $numeroDeDocumento;
    protected $email;
    protected $telefonoCelular;
    protected $telefonoFijo;
   
    // Sobre la transaccion
    protected $contrato;
    
    // Sobre el envio
    protected $categoriaPeso;
    protected $peso;
    protected $detalleDeProductosAEntregar;
    protected $detalleDeProductosARetirar;
    protected $volumen;
    protected $ValorDeclaradoConIva;
    
    public function setDatosDestino($provincia = null, $localidad = null, $codigoPostal = null, $calle = null, $numero = null, $piso = null, $departamento = null, $idCliente = null, $sucursalDeRetiro = null, $sucursalDelCliente = null){
        $this ->setProvincia($provincia)
                ->setLocalidad($localidad)
                ->setCodigoPostal($codigoPostal)
                ->setCalle($calle)
                ->setNumero($numero)
                ->setPiso($piso)
                ->setDepartamento($departamento)
                ->setIdCliente($idCliente)
                ->setSucursalDeRetiro($sucursalDeRetiro)
                ->setSucursalDelCliente($sucursalDelCliente);
    }
    
    public function setDatosDestinatario($nombre = null, $apellido = null, $nombreAlternativo = null, $apellidoAlternativo = null, $tipoDeDocumento = null, $numeroDeDocumento = null, $email = null, $telefonoCelular = null, $telefonoFijo = null){
        $this ->setNombre($nombre)
                ->setApellido($apellido)
                ->setNombreAlternativo($nombreAlternativo)
                ->setApellidoAlternativo($apellidoAlternativo)
                ->setTipoDeDocumento($tipoDeDocumento)
                ->setNumeroDeDocumento($numeroDeDocumento)
                ->setEmail($email)
                ->setTelefonoCelular($telefonoCelular)
                ->setTelefonoFijo($telefonoFijo);
    }
    
    public function setDatosTransaccion($contrato = null){
        $this ->setContrato($contrato);
    }
    
    public function setDatosEnvio($categoriaPeso = null, $peso = null, $volumen = null, $valorDeclaradoConIva = null, $detalleDeProductosAEntregar = null, $detalleDeProductosARetirar = null){
        $this ->setCategoriaPeso($categoriaPeso)
                ->setPeso($peso)
                ->setVolumen($volumen)
                ->setValorDeclaradoConIva($valorDeclaradoConIva)
                ->setDetalleDeProductosAEntregar($detalleDeProductosAEntregar)
                ->setDetalleDeProductosARetirar($detalleDeProductosARetirar);
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getCalle()
    {
        return $this->calle;
    }

    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPiso()
    {
        return $this->piso;
    }

    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getSucursalDeRetiro()
    {
        return $this->sucursalDeRetiro;
    }

    public function setSucursalDeRetiro($sucursalDeRetiro)
    {
        $this->sucursalDeRetiro = $sucursalDeRetiro;

        return $this;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNombreAlternativo()
    {
        return $this->nombreAlternativo;
    }

    public function setNombreAlternativo($nombreAlternativo)
    {
        $this->nombreAlternativo = $nombreAlternativo;

        return $this;
    }

    public function getApellidoAlternativo()
    {
        return $this->apellidoAlternativo;
    }

    public function setApellidoAlternativo($apellidoAlternativo)
    {
        $this->apellidoAlternativo = $apellidoAlternativo;

        return $this;
    }

    public function getTipoDeDocumento()
    {
        return $this->tipoDeDocumento;
    }

    public function setTipoDeDocumento($tipoDeDocumento)
    {
        $this->tipoDeDocumento = $tipoDeDocumento;

        return $this;
    }

    public function getNumeroDeDocumento()
    {
        return $this->numeroDeDocumento;
    }

    public function setNumeroDeDocumento($numeroDeDocumento)
    {
        $this->numeroDeDocumento = $numeroDeDocumento;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    public function setTelefonoCelular($telefonoCelular)
    {
        $this->telefonoCelular = $telefonoCelular;

        return $this;
    }

    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    public function setTelefonoFijo($telefonoFijo)
    {
        $this->telefonoFijo = $telefonoFijo;

        return $this;
    }

    public function getContrato()
    {
        return $this->contrato;
    }

    public function setContrato($contrato)
    {
        $this->contrato = $contrato;

        return $this;
    }

    public function getCategoriaPeso()
    {
        return $this->categoriaPeso;
    }

    public function setCategoriaPeso($categoriaPeso)
    {
        $this->categoriaPeso = $categoriaPeso;

        return $this;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    public function getDetalleDeProductosAEntregar()
    {
        return $this->detalleDeProductosAEntregar;
    }

    public function setDetalleDeProductosAEntregar($detalleDeProductosAEntregar)
    {
        $this->detalleDeProductosAEntregar = $detalleDeProductosAEntregar;

        return $this;
    }

    public function getDetalleDeProductosARetirar()
    {
        return $this->detalleDeProductosARetirar;
    }

    public function setDetalleDeProductosARetirar($detalleDeProductosARetirar)
    {
        $this->detalleDeProductosARetirar = $detalleDeProductosARetirar;

        return $this;
    }

    public function getVolumen()
    {
        return $this->volumen;
    }

    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    public function getValorDeclaradoConIva()
    {
        return $this->ValorDeclaradoConIva;
    }

    public function setValorDeclaradoConIva($ValorDeclaradoConIva)
    {
        $this->ValorDeclaradoConIva = $ValorDeclaradoConIva;

        return $this;
    }

    public function getSucursalDelCliente()
    {
        return $this->sucursalDelCliente;
    }

    public function setSucursalDelCliente($sucursalDelCliente)
    {
        $this->sucursalDelCliente = $sucursalDelCliente;

        return $this;
    }

    public function getWebserviceIndex() {
        return 'generar_envios_de_entrega_y_retiro_con_datos_de_impresion';
    }
}
