<?php
class ParametroValor extends CI_GenericModel{
    
    public $_table  = "parametro_valor";
    public $_pk     = "parametro_valor_id";
        
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
}