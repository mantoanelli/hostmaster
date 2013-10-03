<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modulos extends CI_FormGridController{
    
    public function __construct() {
        parent::__construct('Modulo');
        
        $this->_camposGrid['modulo_id'] = array('label'=>'ID','width'=>'30px','align'=>'center', 'visible'=>1);
        $this->_camposGrid['nome']['width'] = '300px';
                
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()),'gridV1'));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),'gridV1'));
    }  
}