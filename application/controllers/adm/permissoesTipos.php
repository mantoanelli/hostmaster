<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PermissoesTipos extends CI_FormGridController{
    
    public function __construct() {
        //$this->_defaultModel = 'Permissao';
        //$this->_camposGrid = array(1,2,3);
        parent::__construct('Permissao');
        
        $this->_camposGrid['permissao_id'] = array('label'=>'ID','width'=>'30px','align'=>'center', 'visible'=>1);
        $this->_camposGrid['funcionalidade_id']['visible'] = 0;
        $this->_camposGrid['nome']['width'] = '300px';
                
        $this->setData('_classesJs', array(strtolower($this->router->fetch_class()),'gridV1'));
        $this->setData('_classesCss', array(strtolower($this->router->fetch_class()),'gridV1'));
    }  
}