<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Funcionalidades extends CI_FormGridController{
    
    public function __construct() {
        parent::__construct('Funcionalidade');
        
        $this->_camposGrid['nome']['width'] = '300px';
        
        $this->_camposGrid['modulo_id'] = array(
            'label' => 'Módulo',
            'visible' => 1,
            'align'=>'left',
            'width'=>'auto',
            'object'=>'modulo',
            'field'=>'nome',
        );
                
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()),'gridV1'));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),'gridV1'));
    }  
}