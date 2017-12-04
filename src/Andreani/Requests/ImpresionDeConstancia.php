<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class ImpresionDeConstancia implements WebserviceRequest{
    
    protected $numeroDeEnvio;
    
    public function getNumeroDeEnvio() {
        return $this->numeroDeEnvio;
    }

    public function setNumeroDeEnvio($numeroDeEnvio) {
        $this->numeroDeEnvio = $numeroDeEnvio;
        return $this;
    }

    public function getWebserviceIndex() {
        return 'impresion_constancia';
    }
    
}