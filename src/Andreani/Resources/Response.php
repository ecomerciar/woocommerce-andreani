<?php

namespace Andreani\Resources;

class Response{
    
    protected $valid;
    protected $message;
    protected $extra;
    
    public function __construct($message,$valid = true,$extra = null) {
        $this->setMessage($message);
        $this->setValid($valid);
        $this->setExtra($extra);
    }
    
    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function isValid(){
        return $this->valid;
    }
    
    public function setValid($valid){
        $this->valid = $valid;
    }
    
    public function getExtra() {
        return $this->extra;
    }

    public function setExtra($extra) {
        $this->extra = $extra;
    }
    
}