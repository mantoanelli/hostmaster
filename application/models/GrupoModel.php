<?php
class Grupo extends CI_GenericModel{
    
    public $_table  = "grupo";
    public $_pk     = "grupo_id";
        
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
}