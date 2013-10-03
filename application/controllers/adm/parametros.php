<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Parametros extends CI_FormGridController{
    public function __construct() {
        parent::__construct('Parametro');
    
        
        
        $this->applyConfForm(array('nome_constant','descricao'), array(array('width'=>'300px')));
        
        
        $this->_camposForm['nome_constant']['width_label'] = '110px';
        $this->_camposForm['nome_constant']['label'] = 'Nome da constant';
        $this->_camposForm['descricao']['label'] = 'Descrição';
        $this->_camposForm['valores']['type'] = 'include:parametrosValores';
        $this->_camposForm['tipo']['class'] = array('tipo','required');
        $this->applyOrderGrid('parametro_id,nome_constant,descricao,tipo');
        $this->applyOrderForm('nome_constant,descricao,valores');
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class())));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class())));
    }
    
}