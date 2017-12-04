<?php

namespace Andreani\Requests;

use Andreani\Resources\WebserviceRequest;

class ConsultarSucursales implements WebserviceRequest{
    
    protected $codigoPostal;
    protected $localidad;
    protected $provincia;
    
    public function getCodigoPostal() {
        return (string) $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
        return $this;
    }

    public function getLocalidad() {
        return (string) $this->localidad;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
        return $this;
    }

    public function getProvincia() {
        return (string) $this->provincia;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
        return $this;
    }

    public function getWebserviceIndex() {
        return 'sucursales';
    }
    
}