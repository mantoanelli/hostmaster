<?php
class Modulo extends CI_GenericModel{
    
    public $_table  = "modulo";
    public $_pk     = "modulo_id";
    
    public $_association = array(
        array(
            'type'  =>  'n:1', 
            'model' =>  'Funcionalidade',
            'fk'    =>  'modulo_id',
            'alias' =>  'funcionalidade',
            'order' =>  array('ordem'),
        ),
    );
    
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
}