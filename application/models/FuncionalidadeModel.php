<?php
class Funcionalidade extends CI_GenericModel{
    
    public $_table  = "funcionalidade";
    public $_pk     = "funcionalidade_id";
    
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
    public function getPermissions(){
        $perm = new Permissao();
        $permissoes = $perm->getAll("funcionalidade_id IN (0,{$this->getId()})");
        return $permissoes['rows'];
    } 
    
}