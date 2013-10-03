<?php
class UsuarioDominioCobranca extends CI_GenericModel {

    public $_table = "usuario_dominio_cobranca";
    public $_pk = "usuario_dominio_cobranca_id";

    public function __construct($id=null) {
        parent::__construct($id);
    }
    
    public function getUsuarioDominio(){
        return new UsuarioDominio($this->getUsuarioDominioId());
    }
    
    public function save(){
        $id = parent::save();
        
        if($this->getStatus()=='pago'){
            //$this->setStatus('pendente');
            
            
            $dominio = $this->getUsuarioDominio();
            if($dominio->getAccountCpanel()->suspended == 1)
                $dominio->unsuspend_account();
            
            
        }
    }

}
