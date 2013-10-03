<?php
class Parametro extends CI_GenericModel{
    
    public $_table  = "parametro";
    public $_pk     = "parametro_id";
    
    public $_association = array(
        array(
            'type'  =>  'n:1', 
            'model' =>  'ParametroValor',
            'fk'    =>  'parametro_id',
            'alias' =>  'parametro_valor',
            'order' =>  array('data_inicio ASC'),
            //'where' =>  'post_comentario_id_pai = 0'
        ),
    );
    
    public function __construct($id=null) {
        parent::__construct($id);
	}
    
}