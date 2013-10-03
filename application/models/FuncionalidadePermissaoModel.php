<?php
class FuncionalidadePermissao extends CI_GenericModel{
    
    public $_table  = "funcionalidade_permissao";
    public $_pk     = "funcionalidade_permissao_id";
    
    public $_association = array(
        array(
            'type'  =>  '1:1', 
            'model' =>  'Funcionalidade',
            'fk'    =>  'funcionalidade_id',
        ),
        array(
            'type'  =>  '1:1', 
            'model' =>  'Permissao',
            'fk'    =>  'permissao_id',
        ),
    );
    
    public function __construct($id=null,$deleted=false) {
        parent::__construct($id,$deleted);
	}
    
    
    
}