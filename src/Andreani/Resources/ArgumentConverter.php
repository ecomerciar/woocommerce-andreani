<?php

namespace Andreani\Resources;

interface ArgumentConverter{
    
    public function getArgumentChain(WebserviceRequest $consulta);
    
}