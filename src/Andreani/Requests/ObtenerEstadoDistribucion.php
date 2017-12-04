<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class ObtenerEstadoDistribucion implements WebserviceRequest{
    
    protected $codigoDeCliente;
    protected $referenciaExterna;
    protected $numeroDeEnvio;
    
    public function getCodigoDeCliente() {
        return (string) $this->codigoDeCliente;
    }

    public function setCodigoDeCliente($codigoDeCliente) {
        $this->codigoDeCliente = $codigoDeCliente;
        return $this;
    }

    public function getReferenciaExterna() {
        return (string) $this->referenciaExterna;
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

    public function getWebserviceIndex() {
        return 'estado_distribucion';
    }

}