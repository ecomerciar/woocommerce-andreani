<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class CotizarEnvio implements WebserviceRequest{
    
    protected $codigoDeCliente;
    protected $numeroDeContrato;
    protected $codigoPostal;
    protected $codigoDeSucursal;
    protected $peso;
    protected $volumen;
    protected $valorDeclarado;
    
    public function getCodigoDeCliente() {
        return $this->codigoDeCliente;
    }

    public function setCodigoDeCliente($codigoDeCliente) {
        $this->codigoDeCliente = $codigoDeCliente;
        return $this;
    }

    public function getNumeroDeContrato() {
        return $this->numeroDeContrato;
    }

    public function setNumeroDeContrato($numeroDeContrato) {
        $this->numeroDeContrato = $numeroDeContrato;
        return $this;
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
        return $this;
    }

    public function getCodigoDeSucursal() {
        return (string) $this->codigoDeSucursal;
    }

    public function setCodigoDeSucursal($codigoDeSucursal) {
        $this->codigoDeSucursal = $codigoDeSucursal;
        return $this;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = (int) $peso;
        return $this;
    }

    public function getVolumen() {
        return $this->volumen;
    }

    public function setVolumen($volumen) {
        $this->volumen = (int) $volumen;
        return $this;
    }

    public function getValorDeclarado() {
        return $this->valorDeclarado;
    }

    public function setValorDeclarado($valorDeclarado) {
        $this->valorDeclarado = (int) $valorDeclarado;
        return $this;
    }

    public function getWebserviceIndex() {
        return 'cotizacion';
    }
    
}