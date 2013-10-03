<?php
class Permissao extends CI_GenericModel{
    
    public $_table  = "permissao";
    public $_pk     = "permissao_id";
    
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
}