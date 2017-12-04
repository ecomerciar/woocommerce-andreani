<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class ObtenerTrazabilidad implements WebserviceRequest{
    
    protected $referenciaExterna;
    protected $numeroDeEnvio;
    protected $codigoDeCliente;
    
    public function getReferenciaExterna() {
        return $this->referenciaExterna;
    }

    public function setReferenciaExterna($referenciaExterna) {
        $this->referenciaExterna = $referenciaExterna;
        return $this;
    }

    public function getNumeroDeEnvio() {
        return (string) $this->numeroDeEnvio;
    }

    public function setNumeroDeEnvio($numeroDeEnvio) {
        $this->numeroDeEnvio = $numeroDeEnvio;
        return $this;
    }

    public function getCodigoDeCliente() {
        return (string) $this->codigoDeCliente;
    }

    public function setCodigoDeCliente($codigoDeCliente) {
        $this->codigoDeCliente = $codigoDeCliente;
        return $this;
    }

    public function getWebserviceIndex() {
        return 'trazabilidad';
    }

}